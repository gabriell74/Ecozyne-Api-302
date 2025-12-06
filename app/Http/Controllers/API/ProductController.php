<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
            'amount' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = $request->user();
        $community = Community::where('user_id', $user->id)->first();

        try {
            DB::transaction(function () use ($request, $product, $user, $community) {
                
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
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'total_price' => $product->price * $request->amount,
                    'amount' => $request->amount,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengajukan pembelian produk'
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan pembelian produk gagal',
            ], 500);
        }

    }
}
