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
        $today = now()->toDateString();

        $activities = Activity::where('due_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->get()
            ->map(function ($activity) {
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
            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        if ($activity->current_quota >= $activity->quota) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota aktivitas sudah penuh'
            ], 409); // conflict
        }

        $isRegistered = ActivityRegistration::where('activity_id', $activity->id)
            ->where('community_id', $community->id)
            ->exists();

        if ($isRegistered) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar pada aktivitas ini'
            ], 409);
        }

        $registration = ActivityRegistration::create([
            'activity_id' => $activity->id,
            'community_id' => $community->id,
        ]);

        Activity::where('id', $activity->id)->increment('current_quota');

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran Berhasil',
            'data' => $registration,
        ], 200);
    }
}
