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
        $products = Product::latest()->get()->map(function ($product) {
            $product->photo = asset('storage/' . $product->photo);
            return $product;
        });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data produk",
            "data" => $products
        ], 200);
    }

    public function productOrderByCommunity(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'order_customer' => 'required',
            'order_phone_number' => 'required',
            'order_address' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = $request->user();
        $community = Community::where('user_id', $user->id)->first();

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar sebagai komunitas'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'community_id' => $community->id,
                'waste_bank_id' => $product->waste_bank_id,
                'order_customer' => $request->order_customer,
                'order_phone_number' => $request->order_phone_number,
                'order_address' => $request->order_address,
                'status_order' => 'Pending',
                'status_payment' => 'Pending',
            ]);

            ProductTransaction::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'total_price' => $product->price * $request->amount,
                'amount' => $request->amount,
            ]);

            /**
             * SAVE ACTIVITY LOG
             */
            activity()
                ->causedBy($user->id)
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

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengajukan pembelian produk',
                'data' => $order
            ], 201);

        } catch (\Throwable $e) {

            DB::rollBack();

            /**
             * Jika error pun dicatat
             */
            activity()
                ->causedBy($user->id)
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
