<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// >> PERBAIKAN: Ubah BankSampahSubmission menjadi WasteBankSubmission
use App\Models\WasteBankSubmission; // Nama Model yang benar

class WasteBankSubmissionController extends Controller
{
    /**
     * Menampilkan daftar pengajuan bank sampah.
     */
    public function confirBank() 
    {
        // Menggunakan Model yang sudah diperbaiki
        $submissions = WasteBankSubmission::latest()->paginate(10); 
        
        return view('admin.confir_bank', compact('submissions')); 
    }

    /**
     * Menampilkan detail pengajuan bank sampah tertentu.
     */
    public function show($id)
    {
        // Menggunakan Model yang sudah diperbaiki
        $submission = WasteBankSubmission::findOrFail($id);
        
        return view('admin.submission_detail', compact('submission')); 
    }
    
    // Tambahkan method lain seperti approve/reject di sini
}
