<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrashTransaction;

class TrashTransactionController extends Controller
{
    public function trashTransactionByUser(Request $request, $id)
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

    public function trashTransactionByWasteBank(Request $request, $id) 
    {
        $user = $request->user();

        $transactions = TrashTransaction::with(['user'])
            ->where('waste_bank_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => "Daftar pengajuan setoran sampah",
            'data' => $transactions
        ], 200);
    }

    public function approveTransaction(Request $request, $id)
    {
        $transaction = TrashTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Transaksi tidak ditemukan"
            ], 404);
        }

        $poin = $transaction->trash_weight * 10;

        $transaction->update([
            'status' => 'approved',
            'poin_earned' => $poin
        ]);

        return response()->json([
            'success' => true,
            'message' => "Setoran sampah berhasil disetujui",
            'data' => $transaction
        ], 200);
    }

    public function rejectTransaction(Request $request, $id)
    {
        $transaction = TrashTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Transaksi tidak ditemukan"
            ], 404);
        }

        $request->validate([
            'reason' => 'required|string'
        ]);

        $transaction->update([
            'status' => 'rejected',
            'reason' => $request->reason,
            'poin_earned' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Setoran sampah ditolak",
            'data' => $transaction
        ], 200);
    }


}