<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ExchangeTransaction;
use App\Http\Controllers\Controller;
use App\Models\Exchange;

class AdminExchangeRewardController extends Controller
{
    public function getAllExchangeReward() {
        $exchanges = Exchange::with([
            'community:id,user_id,address_id,name,photo',
            'community.user:id,username',
            'community.address',
            'exchangeTransactions.reward:id,reward_name,stock'
        ]) 
        ->orderByRaw("FIELD(exchange_status, 'pending', 'approved', 'rejected') ASC")
        ->orderBy('created_at', 'asc')
        ->paginate(8);

        return view('admin.exchange_reward_list', compact('exchanges'));
    }
}
