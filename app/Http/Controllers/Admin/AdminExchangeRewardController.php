<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExchangeTransaction;
use App\Http\Controllers\Controller;

class AdminExchangeRewardController extends Controller
{
    public function getAllExchangeReward() 
    {
        $exchanges = Exchange::with([
            'community:id,user_id,address_id,name,photo',
            'community.user:id,username',
            'community.address',
            'exchangeTransactions.reward:id,reward_name,stock'
        ]) 
        ->orderByRaw("FIELD(exchange_status, 'pending', 'approved', 'rejected') ASC")
        ->orderBy('created_at', 'asc')
        ->paginate(8);

        $pendingCount = Exchange::where('exchange_status', 'pending')->count();

        return view('admin.exchange_reward_list', compact('exchanges', 'pendingCount'));
    }

    public function rewardExchangeApproval(Request $request, Exchange $exchange)
    {
        $exchange->load('exchangeTransactions.reward', 'community');

        $request->validate([
            'exchange_status' => 'required|in:' . Exchange::STATUS_APPROVED . ',' . Exchange::STATUS_REJECTED,
        ]);

        if ($exchange->exchange_status !== Exchange::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Status hanya dapat diubah jika masih Menunggu.');
        }

        try {
            DB::transaction(function () use ($request, $exchange) {

                $transaction = $exchange->exchangeTransactions->first();
                $reward = $transaction->reward;

                if ($request->exchange_status === Exchange::STATUS_APPROVED) {

                    $updated = DB::table('reward')
                        ->where('id', $reward->id)
                        ->where('stock', '>=', $transaction->amount)
                        ->decrement('stock', $transaction->amount);

                    if ($updated === 0) {
                        throw new \Exception('Stok hadiah tidak mencukupi untuk ' . $reward->reward_name . '.');
                    }

                } elseif ($request->exchange_status === Exchange::STATUS_REJECTED) {
                    DB::table('point')
                        ->where('community_id', $exchange->community->id)
                        ->increment('point', $transaction->total_unit_point);
                }

                $exchange->update(['exchange_status' => $request->exchange_status]);
            });

            return redirect()->back()->with('success', 'Status pertukaran hadiah berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
