<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $products = Product::with('wasteBank.wasteBankSubmission')
            ->latest()
            ->get()
            ->map(function ($product) {

                $product->photo = asset('storage/' . $product->photo);

                $product->waste_bank_name =
                    $product->wasteBank?->wasteBankSubmission?->waste_bank_name;

                unset($product->wasteBank);

                return $product;
            });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data produk",
            "data" => $products
        ], 200);
    }

    public function productOrderByCommunity(Request $request, Product $product)
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
}
