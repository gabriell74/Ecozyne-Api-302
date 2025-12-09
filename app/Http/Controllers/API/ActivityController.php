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

        $activities = Activity::where('registration_due_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->get()
            ->map(function ($activity) {
                $activity->photo = asset('storage/' . $activity->photo);
                return $activity;
            });

        activity()->log('User melihat semua activity');

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data kegiatan",
            "data" => $activities
        ], 200);
    }

    public function getLatestActivity()
    {
        $today = now()->toDateString();

        $activity = Activity::where('registration_due_date', '>=', $today)
            ->latest()
            ->first();

        if ($activity) {
            $activity->photo = asset('storage/' . $activity->photo);
        }

        activity()
            ->withProperties([
                'latest_activity_id' => $activity->id ?? null,
            ])
            ->log('User melihat latest activity');

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil kegiatan terbaru",
            "data" => $activity
        ], 200);
    }

    public function getCompletedActivity()
    {
        $today = now()->toDateString();

        $activities = Activity::where('due_date', '<', $today)
            ->orderBy('due_date', 'desc')
            ->get()
            ->map(function ($activity) {
                $activity->photo = asset('storage/' . $activity->photo);
                return $activity;
            });

        activity()->log('User melihat completed activities');

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data kegiatan yang telah selesai",
            "data" => $activities
        ], 200);
    }

    public function activityRegister(Request $request, Activity $activity)
    {
        $user = $request->user();
        $community = $user->community;

        if (!$community) {
            activity()
                ->causedBy($user)
                ->withProperties(['activity_id' => $activity->id])
                ->log('User gagal daftar karena tidak punya komunitas');

            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        if (now()->toDateString() > $activity->registration_due_date) {
            activity()
                ->causedBy($user)
                ->withProperties(['activity_id' => $activity->id])
                ->log('User gagal daftar karena registration closed');

            return response()->json([
                'success' => false,
                'message' => 'Masa pendaftaran untuk kegiatan ini telah berakhir'
            ], 422);
        }

        if ($activity->current_quota >= $activity->quota) {
            activity()
                ->causedBy($user)
                ->withProperties(['activity_id' => $activity->id])
                ->log('User gagal daftar karena quota penuh');

            return response()->json([
                'success' => false,
                'message' => 'Kuota kegiatan sudah penuh'
            ], 409);
        }

        $isRegistered = ActivityRegistration::where('activity_id', $activity->id)
            ->where('community_id', $community->id)
            ->exists();

        if ($isRegistered) {
            activity()
                ->causedBy($user)
                ->withProperties(['activity_id' => $activity->id])
                ->log('User gagal daftar karena sudah pernah daftar');

            return response()->json([
                'success' => false,
                'message' => 'Sudah terdaftar di kegiatan ini'
            ], 409);
        }

        $registration = ActivityRegistration::create([
            'activity_id' => $activity->id,
            'community_id' => $community->id,
        ]);

        Activity::where('id', $activity->id)->increment('current_quota');

        // SUCCESS
        activity()
            ->causedBy($user)
            ->performedOn($registration)
            ->withProperties([
                'activity_id' => $activity->id,
                'community_id' => $community->id,
            ])
            ->log('User berhasil mendaftar activity');

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran Berhasil',
            'data' => $registration,
        ], 200);
    }

    public function getCommunityActivityRegistrations(Request $request)
    {
        $user = $request->user();
        $community = $user->community;

        if (!$community) {
            activity()->causedBy($user)->log('User gagal melihat registration (no community)');

            return response()->json([
                'success' => false,
                'message' => 'Tidak terdaftar sebagai komunitas'
            ], 404);
        }

        $registrations = ActivityRegistration::where('community_id', $community->id)
            ->with('activity')
            ->latest('created_at')
            ->get()
            ->map(function ($registration) {
                $registration->activity->photo = asset('storage/' . $registration->activity->photo);
                return $registration;
            });

        activity()
            ->causedBy($user)
            ->withProperties(['community_id' => $community->id])
            ->log('User melihat semua registration komunitas');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data pendaftaran kegiatan',
            'data' => $registrations,
        ], 200);
    }

    public function checkRegistrationStatus(Request $request, $activityId)
    {
        $user = $request->user();
        $community = $user->community;

        $isRegistered = ActivityRegistration::where('community_id', $community->id)
            ->where('activity_id', $activityId)
            ->exists();

        activity()
            ->causedBy($user)
            ->withProperties([
                'activity_id' => $activityId,
                'registered' => $isRegistered
            ])
            ->log('User mengecek status pendaftaran activity');

        return response()->json([
            'registered' => $isRegistered
        ]);
    }
}
