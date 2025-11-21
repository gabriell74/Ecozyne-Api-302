<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function getAllCommunity() 
    {
        $communities = Community::latest()->paginate(10); 
        $community_total = Community::count();

        return view('admin.community_list', compact('communities', 'community_total'));
    }

    public function destroyCommunity(Community $community) 
    {
        $user_id = $community->user_id;
        $user = User::findOrFail($user_id);

        try {
            DB::beginTransaction();

            $user->community()->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('community.list')->with('success', 'Akun komunitas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('community.list')->with('fail', 'Akun komunitas gagal dihapus, Silahkan coba lagi');
        }
    }

    public function getAllWasteBank() 
    {
        $waste_banks = WasteBank::latest()->paginate(10); 
        $waste_bank_total = WasteBank::count();

        return view('admin.waste_bank_list', compact('waste_banks', 'waste_bank_total'));
    }

    public function destroyWasteBank(WasteBank $waste_bank)
    {   
        // Waste Bank Submission
        $waste_bank_submission_id = $waste_bank->waste_bank_submission_id;
        $waste_bank_submission = WasteBankSubmission::findOrFail($waste_bank_submission_id);

        // Community
        $community_id = $waste_bank_submission->community_id;
        $community = Community::findOrFail($community_id);

        // User
        $user_id = $community->user_id;
        $user = User::findOrFail($user_id);
        
        try { 
            DB::beginTransaction();

            $waste_bank->delete();
            $waste_bank_submission->delete();
            $community->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('waste_bank.list')->with('success', 'Akun bank sampah berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollbacK();
            return redirect()->route('waste_bank.list')->with('fail', 'Akun bank sampah gagal dihapus, Silahkan coba lagi');
        }
    }
}
