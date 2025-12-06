<?php

namespace App\Http\Controllers\API;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommunityHistoryController extends Controller
{
    // Point Out History 
    public function rewardExchangeHistory(Request $request)
    {
        $user = $request->user();
        $community = $user->community;

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        $exchangeHistory = Exchange::with([
            'exchangeTransactions:id,exchange_id,reward_id,amount,total_unit_point',
            'exchangeTransactions.reward:id,reward_name,photo',
            ])
            ->where('community_id', $community->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($exchange) {
                $exchange->exchangeTransactions->map(function ($transaction) {
                    if ($transaction->reward && $transaction->reward->photo) {
                        $transaction->reward->photo = asset('storage/' . $transaction->reward->photo);
                    }
                    return $transaction;
                });
                return $exchange;
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan riwayat penukaran hadiah',
            'data' => $exchangeHistory,
        ], 200);
    }

    // Point Income
    public function pointIncomeHistory(Request $request)
    {
        $user = $request->user();
        $community = $user->community;

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        $pointIncomeFromRejectedReward = Exchange::with([
            'exchangeTransactions:id,exchange_id,reward_id,amount,total_unit_point',
            'exchangeTransactions.reward:id,reward_name',
            ])
            ->where('community_id', $community->id)
            ->where('exchange_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->get();

        $pointIncomeFromWasteSubmission = []; // Placeholder for future implementation

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan riwayat pemasukan poin',
            'data' => [
                'rejected_reward' => $pointIncomeFromRejectedReward,
                'waste_submission' => $pointIncomeFromWasteSubmission,
            ],
        ], 200);
    }
}
