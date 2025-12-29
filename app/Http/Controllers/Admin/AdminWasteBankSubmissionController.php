<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;

class AdminWasteBankSubmissionController extends Controller
{
    public function getAllWasteBankSubmission() 
    {
        $waste_bank_submissions = WasteBankSubmission::orderByRaw("FIELD(status, 'pending', 'approved', 'rejected') ASC")
        ->orderBy('created_at', 'asc')
        ->paginate(8);

        $pendingCount = WasteBankSubmission::where('status', 'pending')->count();

        return view('admin.waste_bank_submission_list', compact('waste_bank_submissions', 'pendingCount'));
    }

    public function wasteBankSubmissionApproval(Request $request, WasteBankSubmission $waste_bank_submission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        if ($waste_bank_submission->status !== 'pending') {
            return back()->with('error', 'Status hanya dapat diubah jika masih Menunggu.');
        }

        DB::beginTransaction();
        try {
            $waste_bank_submission->update(['status' => $request->status]);

            $community = Community::find($waste_bank_submission->community_id);
            $user = $community ? User::find($community->user_id) : null;

            if ($request->status === 'approved' && $user) {
                $user->update(['role' => 'waste_bank']);

                WasteBank::create([
                    'waste_bank_submission_id' => $waste_bank_submission->id,
                ]);
            }

            DB::commit();

            return back()->with('success', 'Status pengajuan bank sampah berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
