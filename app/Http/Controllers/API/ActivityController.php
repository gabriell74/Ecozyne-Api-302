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

    public function activityRegister(Activity $activity) 
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $community = $user->community;
        $user_id = $user->id;
        $current_quota = $activity->current_quota;
        $quota = $activity->quota;

        if ($current_quota < $quota) {
            
            ActivityRegistration::create([
                'activity_id' => $activity->id,
                'community_id' => $community->id
            ]);

            $current_quota += $current_quota;
            return response()->json([
                'success' => true,
                "message" => "Berhasil mandaftar kegiatan"
            ]);

        } elseif ($current_quota == $quota) {
            return response()->json([
                'success' => true,
                "message" => "Maaf kuota kegiatan penuh"
            ]);
        }

        $activity->save();
    }
}
