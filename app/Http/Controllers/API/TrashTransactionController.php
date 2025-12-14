<?php

namespace App\Http\Controllers\API;

use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Models\TrashTransaction;
use App\Http\Controllers\Controller;

class TrashTransactionController extends Controller
{
    public function trashTransactionByUser(Request $request, $wasteBankId)
    {
        $user = $request->user();

        if (!WasteBank::where('id', $wasteBankId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Bank Sampah tidak ditemukan"
            ], 404);
        }

        if (TrashTransaction::where('waste_bank_id', $wasteBankId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Anda sudah memiliki pengajuan setoran sampah yang sedang diproses di Bank Sampah ini"
            ], 422);
        }

        TrashTransaction::create([
            'waste_bank_id' => $wasteBankId,
            'user_id' => $user->id,
            'status' => "pending"
        ]);

        return response()->json([
            'success' => true,
            'message' => "Pengajuan Setor Sampah Berhasil Dilakukan",
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