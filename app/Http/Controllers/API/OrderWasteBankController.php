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

        if (!$user->wasteBank) {
            abort(403, 'Forbidden: Not a Waste Bank');
        }

        return $user->wasteBank;
    }

    public function getOrdersByWasteBank(Request $request)
    {
        $wasteBank = $this->wasteBankOrFail($request);

        try {
            $orders = Order::where('waste_bank_id', $wasteBank->id)
                ->with(['community', 'productTransaction.product'])
                ->latest()
                ->get()
                ->map(fn ($order) => $this->formatData($order))
                ->groupBy(function ($item) {
                    return match (true) {
                        $item['status'] === 'Pending' => 'incoming',
                        $item['status'] === 'On Delivery' => 'on_delivery',
                        $item['status'] === 'Completed' => 'completed',
                        default => 'canceled_rejected'
                    };
                });

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan data pesanan',
                'data' => [
                    'incoming' => $orders->get('incoming', []),
                    'on_delivery' => $orders->get('on_delivery', []),
                    'completed' => $orders->get('completed', []),
                    'canceled_rejected' => $orders->get('canceled_rejected', []),
                ]
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil pesanan.',
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
        $transaction = $order->productTransaction->first();

        return [
            'id' => $order->id,
            'tanggal' => $order->created_at->format('M d, Y'),
            'communityName' => $order->community->name ?? '-',
            'productName' => $transaction->product->product_name ?? '-',
            'quantity' => $transaction->amount ?? 0,
            'status' => $order->status_order,
            'reason' => $order->cancellation_reason,
        ];
    }
}
