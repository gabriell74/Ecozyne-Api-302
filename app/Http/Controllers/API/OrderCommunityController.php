<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderCommunityController extends Controller
{
    const STATUS_CURRENT = ['Pending', 'On Delivery'];
    const STATUS_ACCEPTED = ['Completed'];
    const STATUS_REJECTED = ['Rejected', 'Canceled'];

    /**
     * GET /api/orders/community
     */
    public function getOrdersByCommunity(Request $request)
    {
        $user = $request->user() ?? abort(401, 'Unauthorized');
        $community = $user->community ?? abort(401, 'Tidak terdaftar sebagai komunitas');

        $orders = Order::where('community_id', $community->id)
            ->with(['productTransaction.product', 'wasteBank'])
            ->latest()
            ->get()
            ->map(fn ($order) => $this->formatData($order))
            ->groupBy(function ($item) {
                if (in_array($item['status'], self::STATUS_CURRENT)) return 'current';
                if (in_array($item['status'], self::STATUS_ACCEPTED)) return 'accepted';
                if (in_array($item['status'], self::STATUS_REJECTED)) return 'rejected';
                return 'other';
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data pesanan',
            'data' => [
                'current'  => $orders->get('current', []),
                'accepted' => $orders->get('accepted', []),
                'rejected' => $orders->get('rejected', []),
            ],
        ]);
    }

    /**
     * POST /api/orders/{orderId}/cancel
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $user = $request->user() ?? abort(401, 'Unauthorized');
        $community = $user->community ?? abort(401, 'Tidak terdaftar sebagai komunitas');

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255',
        ], [
            'reason.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        $validator->validate();

        DB::beginTransaction();

        try {
            $order = Order::where('id', $orderId)
                ->where('community_id', $community->id)
                ->first();

            if (!$order) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan atau Anda tidak memiliki izin.',
                ], 403);
            }

            if (!in_array($order->status_order, ['Pending'])) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan',
                ], 422);
            }

            $order->update([
                'status_order'        => 'Canceled',
                'cancellation_reason' => $request->reason,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan',
                'data'    => [
                    'id'     => $order->id,
                    'status' => $order->status_order,
                    'reason' => $order->cancellation_reason,
                ],
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi',
            ], 500);
        }
    }

    /**
     * Format response per item
     */
    protected function formatData(Order $order)
    {
        $transaction = $order->productTransaction->first();

        return [
            'id'         => $order->id,
            'tanggal'    => $order->created_at->format('M d, Y'),
            'produk'     => $transaction->product->product_name ?? '-',
            'jumlah'     => $transaction->amount ?? 0,
            'metode'     => 'COD',
            'bankSampah' => $order->wasteBank->name ?? '-',
            'status'     => $order->status_order,
            'reason'     => $order->cancellation_reason,
        ];
    }
}
