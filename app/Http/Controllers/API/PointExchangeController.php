<?php

namespace App\Http\Controllers\api;

use App\Models\Reward;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExchangeTransaction;
use App\Http\Controllers\Controller;

class PointExchangeController extends Controller
{
    public function getAllRewards()
    {
        $reward = Reward::inRandomOrder()->get()->map(function ($reward) {
            $reward->photo = asset('storage/' . $reward->photo);
            return $reward;
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data hadiah',
            'data' => $reward,
        ], 200);
    }

    public function getRewardStockById(int $rewardId)
    {
        $rewardStock = Reward::select('id','stock')
            ->where('id', $rewardId
            )->first(); 

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data stok hadiah',
            'data' => $rewardStock,
        ], 200);
    }

    public function exchangeReward(Request $request, Reward $reward)
    {
        $user = $request->user();
        $community = $user->community;

        $request->validate([
            'amount' => 'required|integer|min:1',
            'total_unit_point' => 'required|integer'
        ]);

        if (!$community) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        if ($reward->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok hadiah tidak mencukupi'
            ], 422);
        }

        if ($reward->stock < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah penukaran melebihi stok hadiah',
            ], 422);
        }

        if ($community->point->point < $request->total_unit_point) {
            return response()->json([
                'success' => false,
                'message' => 'Poin tidak mencukupi',
            ], 422);
        }

        DB::beginTransaction();

        try {

            $community->point->decrement('point', $request->total_unit_point);

            $exchange = Exchange::create([
                'community_id' => $community->id,
            ]);

            $exchangeTransaction = ExchangeTransaction::create([
                'exchange_id'        => $exchange->id,
                'reward_id'          => $reward->id,
                'amount'             => $request->amount,
                'total_unit_point'   => $request->total_unit_point
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Penukaran sedang diproses',
                'data'    => [
                    'exchange' => $exchange,
                    'transaction' => $exchangeTransaction,
                ]
            ], 200);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
