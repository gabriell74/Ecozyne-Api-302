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
        $communities = Community::latest()->paginate(8); 

        return view('admin.community_list', compact('communities'));
    }

    public function destroyCommunity(Community $community) {

        $user_id = $community->user_id;
        $user = User::findOrFail($user_id);

        $user->community()->delete();

        $user->delete();

        return redirect()->route('community.list')->with('success', 'Akun komunitas berhasil dihapus');
    }
}
