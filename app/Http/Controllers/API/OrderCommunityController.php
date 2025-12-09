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

        //  Logging activity
        activity()
            ->causedBy($user)
            ->withProperties([
                'community_id' => $community->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User mengambil daftar pesanan komunitas');

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

                //  Logging gagal
                activity()
                    ->causedBy($user)
                    ->withProperties([
                        'order_id' => $orderId,
                        'reason' => $request->reason,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ])
                    ->log('Gagal membatalkan pesanan (tidak ditemukan / unauthorized)');

                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan atau Anda tidak memiliki izin.',
                ], 403);
            }

            if (!in_array($order->status_order, ['Pending'])) {

                // Logging gagal karena status tidak valid
                activity()
                    ->causedBy($user)
                    ->withProperties([
                        'order_id' => $order->id,
                        'current_status' => $order->status_order,
                        'reason' => $request->reason,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ])
                    ->log('User mencoba membatalkan pesanan tetapi status sudah tidak valid');

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

            //  Logging sukses
            activity()
                ->causedBy($user)
                ->withProperties([
                    'order_id' => $order->id,
                    'new_status' => 'Canceled',
                    'reason' => $request->reason,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Pesanan berhasil dibatalkan');

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

            //  Logging error sistem
            activity()
                ->causedBy($user)
                ->withProperties([
                    'order_id' => $orderId,
                    'error_message' => $e->getMessage(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Terjadi kesalahan saat pembatalan pesanan');

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi',
            ], 500);
        }
    }

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
