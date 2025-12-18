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

    public function approveTransaction($id)
    {
        $transaction = TrashTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Transaksi tidak ditemukan"
            ], 404);
        }

        $transaction->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Pengajuan setoran sampah disetujui",
            'data' => $transaction
        ], 200);
    }

    public function storeTrash(Request $request, $id)
    {
        $request->validate([[
            'trash_weight' => 'required|integer|min:1'
        ]]);

        $transaction = TrashTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Transaksi tidak ditemukan"
            ], 404);
        }

        if ($transaction->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi belum disetujui'
            ], 422);
        }

        $poin = $request->trash_weight * 10;

        $transaction->update([
            'trash_weight' => $request->trash_weight,
            'poin_earned' => $poin,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Setoran sampah berhasil, poin ditambahkan",
            'data' => $transaction
        ], 200);
    }

    public function rejectTransaction(Request $request, $id)
    {

        $request->validate([[
            'rejection_reason' => 'required|string'
        ]]);

        $transaction = TrashTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => "Transaksi tidak ditemukan"
            ], 404);
        }

        $transaction->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'poin_earned' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Pengajuan setoran sampah ditolak",
            'data' => $transaction
        ], 200);
    }

    public function historyByUser(Request $request)
    {
        $user = $request->user();

        $history = TrashTransaction::with(['wasteBank'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => "History setoran sampah",
            'data' => $history
        ], 200);
    }
}