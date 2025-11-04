<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteBankSubmission;

class WasteBankSubmissionController extends Controller
{
    /**
     * Menampilkan daftar pengajuan bank sampah.
     */
    public function confirBank() 
    {
        $submissions = WasteBankSubmission::latest()->paginate(10); 
        
        return view('admin.confir_bank', compact('submissions')); 
    }

    /**
     * Menampilkan detail pengajuan bank sampah tertentu.
     */
    public function show($id)
    {
        $submission = WasteBankSubmission::findOrFail($id);
        
        return view('admin.submission_detail', compact('submission')); 
    }
    
}
