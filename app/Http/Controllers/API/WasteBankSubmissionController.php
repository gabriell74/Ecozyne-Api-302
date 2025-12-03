<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;

class WasteBankSubmissionController extends Controller
{
    public function storeWasteBankSubmission(Request $request)
    {
        $user = $request->user();
        $community = $user->community->id;

        $request->validate([
            'waste_bank_name' => 'required|string|max:255',
            'waste_bank_location' => 'required|string|max:300',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:5024',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'file_document' => 'required|mimes:pdf|max:5024',
            'notes' => 'required|string',
        ]);

        $photoPath = $request->file('photo')->store('waste_bank_photos', 'public');
        $documentPath = $request->file('file_document')->store('waste_bank_documents', 'public');

        $wasteBankSubmission = WasteBankSubmission::create([
            'community_id' => $community,
            'waste_bank_name' => $request->waste_bank_name,
            'waste_bank_location' => $request->waste_bank_location,
            'photo' => $photoPath,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'file_document' => $documentPath,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan bank sampah berhasil dikirim dan sedang dalam proses peninjauan.',
            'data' => $wasteBankSubmission,
        ], 201);
    }
}
