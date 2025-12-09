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
            ->where('id', $rewardId)
            ->first();

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
            activity()
                ->causedBy($user)
                ->event('exchange_failed')
                ->performedOn($reward)
                ->withProperties(['reason' => 'community_not_found'])
                ->log('Penukaran gagal: pengguna bukan komunitas');

            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        if ($reward->stock <= 0) {
            activity()
                ->causedBy($user)
                ->event('exchange_failed')
                ->performedOn($reward)
                ->withProperties(['reason' => 'empty_stock'])
                ->log('Penukaran gagal: stok kosong');

            return response()->json([
                'success' => false,
                'message' => 'Stok hadiah tidak mencukupi'
            ], 422);
        }

        if ($reward->stock < $request->amount) {
            activity()
                ->causedBy($user)
                ->event('exchange_failed')
                ->performedOn($reward)
                ->withProperties([
                    'requested_amount' => $request->amount,
                    'stock' => $reward->stock
                ])
                ->log('Penukaran gagal: stok tidak cukup');

            return response()->json([
                'success' => false,
                'message' => 'Jumlah penukaran melebihi stok hadiah',
            ], 422);
        }

        if ($community->point->point < $request->total_unit_point) {
            activity()
                ->causedBy($user)
                ->event('exchange_failed')
                ->performedOn($reward)
                ->withProperties([
                    'point_needed' => $request->total_unit_point,
                    'current_point' => $community->point->point
                ])
                ->log('Penukaran gagal: poin tidak mencukupi');

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

            activity()
                ->causedBy($user)
                ->event('exchange_success')
                ->performedOn($exchange)
                ->withProperties([
                    'reward_id' => $reward->id,
                    'amount' => $request->amount,
                    'total_point_used' => $request->total_unit_point
                ])
                ->log('Penukaran poin berhasil');

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

            activity()
                ->causedBy($user)
                ->event('exchange_error')
                ->performedOn($reward)
                ->withProperties(['error' => $e->getMessage()])
                ->log('Penukaran gagal karena error sistem');

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
