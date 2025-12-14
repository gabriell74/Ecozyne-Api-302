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
        $wasteBanks = WasteBank::query()
            ->join(
                'waste_bank_submission',
                'waste_bank_submission.id',
                '=',
                'waste_bank.waste_bank_submission_id'
            )
            ->where('waste_bank_submission.status', 'approved')
            ->orderByDesc('waste_bank.created_at')
            ->get([
                'waste_bank.id',
                'waste_bank_submission.community_id',

                'waste_bank_submission.waste_bank_name',
                'waste_bank_submission.waste_bank_location',
                'waste_bank_submission.photo',
                'waste_bank_submission.latitude',
                'waste_bank_submission.longitude',
                'waste_bank_submission.file_document',
                'waste_bank_submission.notes',
                'waste_bank_submission.status',

                'waste_bank.created_at',
                'waste_bank.updated_at',
            ])
            ->map(function ($wasteBank) {
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
