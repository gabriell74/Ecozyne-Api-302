<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\WasteBank;
use App\Models\Community;
use App\Models\WasteBankSubmission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductWasteBankController extends Controller
{
    private $wasteBank;
    private $errorResponse;

    public function __construct()
    {
        $user = Auth::user();
        
        $community = Community::where('user_id', $user->id)->first();
        
        if (!$community) {
            $this->errorResponse = response()->json([
                'success' => false,
                'message' => 'Komunitas tidak ditemukan'
            ], 404);
            return;
        }
        
        $wasteBankSubmission = WasteBankSubmission::where('community_id', $community->id)
            ->where('status', 'approved')
            ->first();
            
        if (!$wasteBankSubmission) {
            $this->errorResponse = response()->json([
                'success' => false,
                'message' => 'Waste Bank belum disetujui'
            ], 404);
            return;
        }
        
        $wasteBank = WasteBank::where('waste_bank_submission_id', $wasteBankSubmission->id)->first();
        
        if (!$wasteBank) {
            $this->errorResponse = response()->json([
                'success' => false,
                'message' => 'Waste Bank tidak ditemukan'
            ], 404);
            return;
        }
        
        $this->wasteBank = $wasteBank;
    }

    public function getWasteBankProducts()
    {
        if ($this->errorResponse) {
            return $this->errorResponse;
        }
        
        $products = Product::where('waste_bank_id', $this->wasteBank->id)
            ->latest()
            ->get();

        foreach ($products as $product) {
            if($product->photo) {
                $product->photo_url = asset('storage/' . $product->photo);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil produk waste bank',
            'data' => $products
        ], 200);
    }

    public function getWasteBankProductDetail($id)
    {
        if ($this->errorResponse) {
            return $this->errorResponse;
        }
        
        $product = Product::where('id', $id)
            ->where('waste_bank_id', $this->wasteBank->id)
            ->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan atau tidak memiliki akses'
            ], 404);
        }

        if ($product->photo) {
            $product->photo_url = asset('storage/' . $product->photo);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil detail produk',
            'data' => $product
        ], 200);
    }

    public function createWasteBankProduct(Request $request)
    {
        if ($this->errorResponse) {
            return $this->errorResponse;
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5024',
        ]);

        $photoPath = $request->file('photo')->store('products', 'public');

        $product = Product::create([
            'waste_bank_id' => $this->wasteBank->id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'photo' => $photoPath,
        ]);

        $product->photo_url = asset('storage/' . $product->photo);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    public function updateWasteBankProduct(Request $request, $id)
    {
        if ($this->errorResponse) {
            return $this->errorResponse;
        }
        
        $product = Product::where('id', $id)
            ->where('waste_bank_id', $this->wasteBank->id)
            ->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5024',
        ]);

        $dataToUpdate = $request->only(['product_name', 'description', 'price', 'stock']);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }

            $photoPath = $request->file('photo')->store('products', 'public');
            $dataToUpdate['photo'] = $photoPath;
        }

        $product->update($dataToUpdate);

        $product->photo_url = asset('storage/' . $product->photo);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ], 200);
    }

    public function deleteWasteBankProduct($id)
    {
        if ($this->errorResponse) {
            return $this->errorResponse;
        }
        
        $product = Product::where('id', $id)
            ->where('waste_bank_id', $this->wasteBank->id)
            ->first();
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}
