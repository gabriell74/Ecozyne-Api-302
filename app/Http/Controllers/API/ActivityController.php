<?php

namespace App\Http\Controllers\API;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityRegistration;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function getAllActivity() 
    {
        $activities = Activity::latest()->get()->map(function ($activity) {
            $activity->photo = asset('storage/' . $activity->photo);
            return $activity;
        });

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data aktivitas",
            "data" => $activities
        ], 200);
    }

    public function activityRegister(Request $request, Activity $activity) 
    {
        $user = $request->user();

        $community = $user->community;

        if (!$community) {
            return response()->json(['message' => 'Tidak terdaftar sebagai komunitas'], 404);
        }

        $registration = ActivityRegistration::create([
            'activity_id' => $activity->id,
            'community_id' => $community->id,
        ]);

        return response()->json([
            'message' => 'Pendaftaran Berhasil', 
            'data' => $registration,
        ]);
    }
}
