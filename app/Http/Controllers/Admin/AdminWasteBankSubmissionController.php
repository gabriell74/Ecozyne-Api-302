<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
            return redirect()->back()->with('error', 'Status hanya dapat diubah jika masih Menunggu.');
        }

        $waste_bank_submission->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pertukaran hadiah berhasil diperbarui.');
    }
}
