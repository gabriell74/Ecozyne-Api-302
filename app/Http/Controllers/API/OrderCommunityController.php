<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderCommunityController extends Controller
{
    const STATUS_CURRENT = ['Pending', 'On Delivery'];
    const STATUS_ACCEPTED = ['Completed'];
    const STATUS_REJECTED = ['Rejected', 'Canceled'];

    public function placeOrder(Request $request, Product $product)
    {
        $user = $request->user();
        $community = Community::where('user_id', $user->id)->first();
        
        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar sebagai komunitas'
            ], 404);
        }

        if ($product->stock  <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis'
            ], 422);
        }

        if ($product->stock < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ], 422);
        }

        $request->validate([
            'order_customer' => 'required',
            'order_phone_number' => 'required',
            'order_address' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'community_id' => $community->id,
                'waste_bank_id' => $product->waste_bank_id,
                'order_customer' => $request->order_customer,
                'order_phone_number' => $request->order_phone_number,
                'order_address' => $request->order_address,
                'status_order' => 'pending',
                'status_payment' => 'pending',
            ]);

            ProductTransaction::create([
                'order_id'      => $order->id,
                'product_id'    => $product->id,
                'product_name'  => $product->product_name, // snapshot
                'product_price' => $product->price,         // snapshot
                'amount'        => $request->amount,
                'total_price'   => $product->price * $request->amount,
            ]);


            $product->decrement('stock', $request->amount);

            /**
             * SAVE ACTIVITY LOG
             */
            activity()
                ->causedBy($user)
                ->performedOn($order)
                ->event('order_created')
                ->withProperties([
                    'community_id' => $community->id,
                    'product_id' => $product->id,
                    'amount' => $request->amount,
                    'total_price' => $product->price * $request->amount,
                    'waste_bank_id' => $product->waste_bank_id,
                ])
                ->log('Komunitas mengajukan pembelian produk');

            DB::commit();

           $productTransaction = ProductTransaction::where('order_id', $order->id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengajukan pembelian produk',
                'data' => [
                    'order' => [
                        'id' => $order->id,
                        'community_id' => $order->community_id,
                        'waste_bank_id' => $order->waste_bank_id,
                        'order_customer' => $order->order_customer,
                        'order_phone_number' => $order->order_phone_number,
                        'order_address' => $order->order_address,
                        'status_order' => $order->status_order,
                        'status_payment' => $order->status_payment,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                        'product_transactions' => $productTransaction->map(function ($item) {
                            return [
                                'product_id'    => $item->product_id,
                                'product_name'  => $item->product_name,   // snapshot
                                'product_price' => $item->product_price,  // snapshot
                                'amount'        => $item->amount,
                                'total_price'   => $item->total_price,
                            ];
                        })
                    ]
                ]
            ], 201);
        } catch (\Throwable $e) {

            DB::rollBack();

            /**
             * Jika error pun dicatat
             */
            activity()
                ->causedBy($user)
                ->event('order_failed')
                ->withProperties([
                    'message' => $e->getMessage(),
                    'request_payload' => $request->all()
                ])
                ->log('Gagal mengajukan pembelian produk');

            return response()->json([
                'success' => false,
                'message' => 'Pengajuan pembelian produk gagal',
            ], 500);
        }
    }

    /**
     * PUT /api/orders/community/{orderId}/cancel
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $user = $request->user() ?? abort(401, 'Unauthorized');
        $community = $user->community ?? abort(401, 'Tidak terdaftar sebagai komunitas');

        $validator = Validator::make($request->all(), [
            'cancellation_reason' => 'required|string|max:255',
        ], [
            'cancellation_reason.required' => 'Alasan pembatalan wajib diisi.',
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
                        'cancellation_reason' => $request->cancellation_reason,
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

            if (!in_array($order->status_order, ['pending'])) {

                // Logging gagal karena status tidak valid
                activity()
                    ->causedBy($user)
                    ->withProperties([
                        'order_id' => $order->id,
                        'current_status' => $order->status_order,
                        'cancellation_reason' => $request->cancellation_reason,
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
                'status_order'        => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'status_payment'      => 'failed',
            ]);

            DB::commit();

            //  Logging sukses
            activity()
                ->causedBy($user)
                ->withProperties([
                    'order_id' => $order->id,
                    'new_status' => 'Canceled',
                    'cancellation_reason' => $request->cancellation_reason,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Pesanan berhasil dibatalkan');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan',
                'data'    => [
                    'id'     => $order->id,
                    'status_order' => $order->status_order,
                    'status_payment' => $order->status_payment,
                    'cancellation_reason' => $order->cancellation_reason,
                ],
            ], 200);

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
            'cancellation_reason'     => $order->cancellation_reason,
        ];
    }
}
