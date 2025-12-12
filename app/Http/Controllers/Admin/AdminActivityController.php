<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityRegistration;
use Illuminate\Support\Facades\Storage;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllActivity()
    {
        $activities = Activity::latest()->paginate(8); 

        return view('admin.activity_list', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'location' => 'required',
            'quota' => 'required',
            'registration_start_date' => 'required|date|before_or_equal:registration_due_date',
            'registration_due_date' => 'required|date|after_or_equal:registration_start_date',
            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $path = $request->file('photo')->store('activity', 'public');

        Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
            'location' => $request->location,
            'current_quota' => 0,
            'quota' => $request->quota,
            'registration_start_date' => $request->registration_start_date,
            'registration_due_date' => $request->registration_due_date,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('activity.list')->with('success', 'Berhasil menambah kegiatan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view('admin.activity_detail', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('admin.activity_edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'location' => 'required',
            'quota' => 'required',

            'registration_start_date' => 'required|date|before_or_equal:registration_due_date',
            'registration_due_date' => 'required|date|after_or_equal:registration_start_date',

            'start_date' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->location = $request->location;
        $activity->quota = $request->quota;
        $activity->registration_start_date = $request->registration_start_date;
        $activity->registration_due_date = $request->registration_due_date;
        $activity->start_date = $request->start_date;
        $activity->due_date = $request->due_date;

        if ($request->hasFile('photo')) {
            if ($activity->photo) {
                Storage::delete('public/' . $activity->photo);
            }

            $path = $request->file('photo')->store('activity', 'public');
            $activity->photo = $path;
        }

        $activity->save();

        return redirect()->route('activity.list')->with('success', 'Aktivitas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if ($activity->photo && Storage::disk('public')->exists($activity->photo)) {
            Storage::disk('public')->delete($activity->photo);
        }

        $activity->delete();

        return redirect()->route('activity.list')->with('success', 'Berhasil menghapus aktivitas!');
    }

    public function getActivityMember($activity_id)
    {
        $activity_registration = ActivityRegistration::where('activity_id', $activity_id)->get();
        $community_ids = $activity_registration->pluck('community_id');
        $communities = Community::whereIn('id', $community_ids)->paginate(8);
        $community_total = $communities->count();

        return view('admin.activity_member', compact('communities', 'community_total'));
    }
}
