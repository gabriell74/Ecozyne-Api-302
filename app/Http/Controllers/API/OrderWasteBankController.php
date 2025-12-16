<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderWasteBankController extends Controller
{
    private function wasteBankOrFail(Request $request)
    {
        $user = $request->user() ?? abort(401, 'Unauthorized');

        $community = $user->community;
        if (! $community) {
            abort(403, 'Dilarang: pengguna belum tergabung dalam komunitas');
        }

        $submission = $community?->wasteBankSubmission;

        if (!$submission) {
            abort(403, 'Dilarang: komunitas ini belum mengajukan pendaftaran sebagai bank sampah');
        }

        if (! $submission || strtolower($submission->status) !== 'approved') {
            abort(403, 'Dilarang: komunitas ini belum disetujui sebagai bank sampah');
        }

        $wasteBank = $submission->wasteBank;
        if (! $wasteBank) {
            abort(403, 'Dilarang: waste bank belum terdaftar untuk submission ini');
        }

        if ($user->id !== $community->user_id && ($user->role ?? null) !== 'waste_bank') {
            abort(403, 'Dilarang: bukan penanggung jawab bank sampah ini');
        }

        return $wasteBank;
    }

    public function getWasteBankOrders(Request $request)
    {
        $wasteBank = $this->wasteBankOrFail($request);

        try {
            $orders = Order::where('waste_bank_id', $wasteBank->id)
                ->with([
                    'productTransactions',
                ])
                ->latest()
                ->get()
                ->map(fn (Order $order) => $this->formatData($order));

            activity()
                ->causedBy($request->user())
                ->withProperties([
                    'waste_bank_id' => $wasteBank->id,
                    'ip' => $request->ip(),
                ])
                ->log('Mengambil pesanan customer untuk waste bank');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan pesanan customer',
                'data'    => $orders,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil pesanan customer',
            ], 500);
        }
}

    public function acceptOrder(Request $request, $orderId)
    {
        return $this->updateOrder($request, $orderId, 'On Delivery', 'Pesanan diterima');
    }

    public function rejectOrder(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->updateOrder($request, $orderId, 'Rejected', 'Pesanan ditolak', $request->reason);
    }

    public function completeOrder(Request $request, $orderId)
    {
        return $this->updateOrder($request, $orderId, 'Completed', 'Pesanan selesai', null, ['On Delivery']);
    }

    private function updateOrder(
        Request $request,
        $orderId,
        $targetStatus,
        $successMessage,
        $reason = null,
        $allowedStatus = ['Pending']
    ) {
        $wasteBank = $this->wasteBankOrFail($request);

        DB::beginTransaction();

        try {
            $order = Order::where('id', $orderId)
                ->where('waste_bank_id', $wasteBank->id)
                ->first();

            if (!$order) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            if (!in_array($order->status_order, $allowedStatus)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Status pesanan tidak bisa diubah dari {$order->status_order}"
                ], 409);
            }

            $dataUpdate = [
                'status_order' => $targetStatus
            ];

            if ($targetStatus === 'Rejected') {
                $dataUpdate['cancellation_reason'] = $reason;
            }

            $order->update($dataUpdate);

            DB::commit();

            //  LOG
            activity()
                ->causedBy($request->user())
                ->performedOn($order)
                ->withProperties([
                    'order_id'       => $order->id,
                    'old_status'     => $order->status_order,
                    'new_status'     => $targetStatus,
                    'reason'         => $reason,
                    'ip'             => $request->ip(),
                ])
                ->log("Mengubah status pesanan menjadi {$targetStatus}");

            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'data' => $this->formatData($order)
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
            ], 500);
        }
    }

    private function formatData(Order $order)
    {
        $transaction = $order->productTransactions->first();

        return [
            'id' => $order->id,
            'customer_name' => $order->order_customer ?? '-',
            'phone_number' => $order->order_phone_number ?? '-',
            'address' => $order->order_address ?? '-',
            'total_price' => $transaction->total_price ?? 0,
            'amount' => $transaction->amount ?? 0,
            'product_name' => $transaction->product_name ?? '-',
            'status_order' => $order->status_order,
            'status_payment' => $order->status_payment,
            'cancellation_reason' => $order->cancellation_reason,
            'created_at' => $order->created_at,
        ];
    }
}
