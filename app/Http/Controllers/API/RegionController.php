<?php

namespace App\Http\Controllers\API;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::select('id', 'kecamatan')
            ->with(['kelurahan' => function ($query) {
                $query->select('id', 'kecamatan_id', 'kelurahan');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kecamatan,
        ]);
    }
}
