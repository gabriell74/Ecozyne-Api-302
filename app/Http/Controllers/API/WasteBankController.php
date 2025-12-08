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
        $wastebanks = WasteBank::latest()->get()->map(function ($wastebank) {
            return $wastebank->load('wasteBankSubmission');
        });

        return response()->json([
            "success" => true,
            "massage" => "Berhasil mengambil list bank sampah",
            "data" => $wastebanks
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
