<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrashTransaction;

class TrashTransactionController extends Controller
{
    public function trashTransactionByCommunity(Request $request, $id)
    {
        $user = $request->user();

        $trash_transaction = TrashTransaction::create([
            'waste_bank_id' => $id,
            'user_id' => $user->id,
            'status' => "pending"
        ]);

        return response()->json([
            'success' => true,
            'message' => "Pengajuan Setor Sampah Berhasil Dilakukan",
            'data' => $trash_transaction
        ], 201);



    }
}
