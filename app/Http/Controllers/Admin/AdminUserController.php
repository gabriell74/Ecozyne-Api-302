<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function getAllCommunity() {
        $communities = Community::latest()->paginate(10); 
        $community_total = Community::count();

        return view('admin.community_list', compact('communities', 'community_total'));
    }

    public function destroyCommunity(Community $community) {

        $user_id = $community->user_id;
        $user = User::findOrFail($user_id);

        $user->community()->delete();

        $user->delete();

        return redirect()->route('community.list')->with('success', 'Akun komunitas berhasil dihapus');
    }

    public function getAllWasteBank() {
        $waste_banks = WasteBank::latest()->paginate(10); 
        $waste_bank_total = WasteBank::count();

        return view('admin.waste_bank_list', compact('waste_banks', 'waste_bank_total'));
    }

    public function destroyWasteBank(WasteBank $waste_bank) {

        $user_id = $waste_bank->user_id;
        $user = User::findOrFail($user_id);

        $user->waste_bank()->delete();

        $user->delete();

        return redirect()->route('waste_bank.list')->with('success', 'Akun bank sampah berhasil dihapus');
    }
}
