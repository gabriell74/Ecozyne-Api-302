<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WasteBankSubmission;
use Spatie\Activitylog\Models\Activity;

class WasteBankSubmissionController extends Controller
{
    public function storeWasteBankSubmission(Request $request)
    {
        $user = $request->user();
        $community = $user->community->id;

        if (WasteBankSubmission::where('community_id', $community)
            ->where('status', 'pending')
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda memiliki pengajuan bank sampah yang sedang diproses.',
            ], 400);
        }
        
        if (WasteBankSubmission::where('community_id', $community)
            ->where('status', 'approved')
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar sebagai bank sampah.',
            ], 400);
        }

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

        activity()
            ->performedOn($wasteBankSubmission)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $wasteBankSubmission->toArray()
            ])
            ->log('Pengguna mengajukan Bank Sampah');

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan bank sampah sedang diproses.',
            'data' => $wasteBankSubmission,
        ], 201);
    }


    public function getSubmissionHistory(Request $request)
    {
        $user = $request->user();
        $communityId = $user->community->id;

        $submissions = WasteBankSubmission::where('community_id', $communityId)
                        ->get()
                        ->map(function ($submission) {
                            $submission->photo = asset('storage/' . $submission->photo);
                            $submission->file_document = asset('storage/' . $submission->file_document);
                            return $submission;
                        });

        activity()
            ->causedBy($user)
            ->withProperties([
                'result_count' => $submissions->count()
            ])
            ->log('Melihat riwayat pengajuan bank sampah');

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pengajuan ditemukan.',
            'data' => $submissions,
        ], 200);
    }

    public function checkSubmissionsStatus(Request $request)
    {
        $user = $request->user();
        $community = $user->community;

        $hasPending = WasteBankSubmission::where('community_id', $community->id)
            ->where('status', 'pending')
            ->exists();

        activity()
            ->causedBy($user)
            ->withProperties([
                'community_id' => $community->id,
                'has_pending' => $hasPending,
            ])
            ->log('Mengecek status pengajuan bank sampah');

        return response()->json([
            'has_pending' => $hasPending,
        ], 200);
    }
}
