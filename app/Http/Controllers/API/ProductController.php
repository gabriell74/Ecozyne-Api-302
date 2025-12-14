<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Controllers\Controller;

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

    public function getProductDetail($id)
    {
        $product = Product::with('wasteBank.wasteBankSubmission')
            ->find($id);

        if (!$product) {
            return response()->json([
                "success" => false,
                "message" => "Produk tidak ditemukan"
            ], 404);
        }

        $product->photo = asset('storage/' . $product->photo);

        $product->waste_bank_name =
            $product->wasteBank?->wasteBankSubmission?->waste_bank_name;

        unset($product->wasteBank);

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil detail produk",
            "data" => $product
        ], 200);
    }

}
