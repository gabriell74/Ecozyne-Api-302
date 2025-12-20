<?php

namespace App\Http\Controllers\API;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrashTransaction;

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
            'exchangeTransactions.reward:id,reward_name',
            ])
            ->where('community_id', $community->id)
            ->orderBy('created_at', 'desc')
            ->get();

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

        $pointIncomeFromWasteSubmission = TrashTransaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transaction) {
                $transaction->trash_image = $transaction->trash_image
                    ? asset('storage/' . $transaction->trash_image)
                    : null;
                return $transaction;
            });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan riwayat pemasukan poin',
            'data' => [
                'rejected_reward' => $pointIncomeFromRejectedReward,
                'waste_submission' => $pointIncomeFromWasteSubmission,
            ],
        ], 200);
    }

   public function productOrderHistory(Request $request)
    {
        $user = $request->user();
        $community = $user->community;

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        $orders = $community->orders()
            ->with('productTransactions')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $orders->map(function ($order) {
            return [
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
                'product_transactions' => $order->productTransactions->map(function ($item) {
                    return [
                        'product_id'    => $item->product_id,
                        'product_name'  => $item->product_name,
                        'product_price' => $item->product_price,
                        'amount'        => $item->amount,
                        'total_price'   => $item->total_price,
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan riwayat pesanan',
            'data' => $data,
        ], 200);
    }
}
