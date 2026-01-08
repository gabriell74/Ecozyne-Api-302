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

    public function placeOrder(Request $request, int $productId)
    {
        $user = $request->user();

        $community = Community::where('user_id', $user->id)->first();
        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar sebagai komunitas'
            ], 404);
        }

        $request->validate([
            'order_customer' => 'required',
            'order_phone_number' => 'required',
            'order_address' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            /**
             * AMBIL PRODUCT DI DALAM TRANSAKSI + LOCK
             */
            $lockedProduct = Product::where('id', $productId)
                ->lockForUpdate()
                ->first();

            if (!$lockedProduct) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            /**
             *  CEK STOK SETELAH LOCK
             */
            if ($lockedProduct->stock <= 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk habis'
                ], 422);
            }

            if ($lockedProduct->stock < $request->amount) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi'
                ], 422);
            }

            /**
             * CREATE ORDER
             */
            $order = Order::create([
                'community_id' => $community->id,
                'waste_bank_id' => $lockedProduct->waste_bank_id,
                'order_customer' => $request->order_customer,
                'order_phone_number' => $request->order_phone_number,
                'order_address' => $request->order_address,
                'status_order' => 'pending',
                'status_payment' => 'pending',
            ]);

            /**
             * SNAPSHOT PRODUCT
             */
            ProductTransaction::create([
                'order_id'      => $order->id,
                'product_id'    => $lockedProduct->id,
                'product_name'  => $lockedProduct->product_name,
                'product_price' => $lockedProduct->price,
                'amount'        => $request->amount,
                'total_price'   => $lockedProduct->price * $request->amount,
            ]);

            /**
             * DECREMENT STOK (AMAN)
             */
            $lockedProduct->decrement('stock', $request->amount);

            /**
             * ACTIVITY LOG
             */
            activity()
                ->causedBy($user)
                ->performedOn($order)
                ->event('order_created')
                ->withProperties([
                    'community_id' => $community->id,
                    'product_id' => $lockedProduct->id,
                    'amount' => $request->amount,
                    'total_price' => $lockedProduct->price * $request->amount,
                    'waste_bank_id' => $lockedProduct->waste_bank_id,
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
                                'product_name'  => $item->product_name,
                                'product_price' => $item->product_price,
                                'amount'        => $item->amount,
                                'total_price'   => $item->total_price,
                            ];
                        })
                    ]
                ]
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

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
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan atau Anda tidak memiliki izin.',
                ], 403);
            }

            if ($order->status_order !== 'pending') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan',
                ], 422);
            }

            /**
             * AMBIL SNAPSHOT PRODUCT (PASTI 1)
             */
            $productTransaction = ProductTransaction::where('order_id', $order->id)->first();

            if (!$productTransaction) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Data produk pesanan tidak ditemukan',
                ], 422);
            }

            /**
             * LOCK PRODUCT
             */
            $product = Product::where('id', $productTransaction->product_id)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Produk sudah tidak tersedia',
                ], 422);
            }

        
            $product->increment('stock', $productTransaction->amount);

            /**
             * UPDATE STATUS ORDER
             */
            $order->update([
                'status_order'        => 'cancelled',
                'status_payment'      => 'failed',
                'cancellation_reason' => $request->cancellation_reason,
            ]);

            DB::commit();

            activity()
                ->causedBy($user)
                ->performedOn($order)
                ->event('order_cancelled')
                ->withProperties([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'amount'     => $productTransaction->amount,
                ])
                ->log('Pesanan dibatalkan dan stok dikembalikan');

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

            activity()
                ->causedBy($user)
                ->event('order_cancel_failed')
                ->withProperties([
                    'error' => $e->getMessage(),
                ])
                ->log('Gagal membatalkan pesanan');

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
