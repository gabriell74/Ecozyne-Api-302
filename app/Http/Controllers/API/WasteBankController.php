<?php

namespace App\Http\Controllers\API;

use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;

class WasteBankController extends Controller
{
    public function getAllWasteBank()
    {
        // 
    }

    public function wasteBankDetail(WasteBank $wasteBank)
    {
        $wasteBankDetail = $wasteBank->load('wasteBankSubmission');

        return response()->json([
            'wasteBankDetail' => $wasteBankDetail,
        ], 200);
    }
}
