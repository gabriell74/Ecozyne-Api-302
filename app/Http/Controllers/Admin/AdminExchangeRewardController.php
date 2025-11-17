<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ExchangeTransaction;
use App\Http\Controllers\Controller;

class AdminExchangeRewardController extends Controller
{
    public function getAllExchangeReward() {
        $exchange_rewards = ExchangeTransaction::paginate(8); 

        return view('admin.exchange_reward_list', compact('exchange_rewards'));
    }
}
