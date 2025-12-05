<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\EcoEnzymeTracking;
use App\Http\Controllers\Controller;

class EcoEnzymeTrackingController extends Controller
{
    public function getAllBatches(Request $request)
    {
        $user = $request->user();
        $community = $user->community;
        $wasteBankId = $community->wasteBankSubmission?->wasteBank?->id;

        if (!$wasteBankId) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki Bank Sampah yang terdaftar',
            ], 404);
        }

        $batches = EcoEnzymeTracking::where('waste_bank_id', $wasteBankId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar batch eco-enzyme berhasil diambil',
            'data' => $batches,
        ], 200);
    }

    public function storeBatch(Request $request)
    {
        $user = $request->user();
        $community = $user->community;
        $wasteBankId = $community->wasteBankSubmission?->wasteBank?->id;

        if (!$wasteBankId) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki Bank Sampah yang terdaftar',
            ], 404);
        }

        $validatedData = $request->validate([
            'batch_name' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        $validatedData['waste_bank_id'] = $wasteBankId;

        $ecoEnzymeTracking = EcoEnzymeTracking::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Batch eco-enzyme berhasil disimpan',
            'data' => $ecoEnzymeTracking,
        ], 201);
    }

}
