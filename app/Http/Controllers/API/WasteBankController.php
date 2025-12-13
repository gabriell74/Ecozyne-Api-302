<?php

namespace App\Http\Controllers\API;

use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;
use Monolog\Handler\WebRequestRecognizerTrait;

class WasteBankController extends Controller
{
    public function getAllWasteBank()
    {
        $wasteBanks = WasteBankSubmission::where('status', 'approved')
            ->latest()
            ->get([
                'id',
                'community_id',
                'waste_bank_name',
                'waste_bank_location',
                'photo',
                'latitude',
                'longitude',
                'file_document',
                'notes',
                'status',
                'created_at',
                'updated_at'
            ])->map(function ($wasteBank) {
                $wasteBank->photo = asset('storage/' . $wasteBank->photo);
                return $wasteBank;
            });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil list bank sampah",
            "data" => $wasteBanks
        ], 200);
    }


    public function wasteBankDetail(WasteBank $wasteBank)
    {
        $wasteBankDetail = $wasteBank->load('wasteBankSubmission');

        return response()->json([
            'wasteBankDetail' => $wasteBankDetail,
        ], 200);
    }
}
