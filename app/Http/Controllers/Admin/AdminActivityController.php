<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllActivity()
    {
        $activities = Activity::latest()->get(); 

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
            'quota' => 'required',
            'duedate' => 'required|date',
        ]);

        $path = $request->file('photo')->store('activity', 'public');

        Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $path,
            'quota' => $request->quota,
            'duedate' => $request->duedate,
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
            'quota' => 'required',
            'duedate' => 'required|date',
        ]);

        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->quota = $request->quota;
        $activity->duedate = $request->duedate;

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

        return redirect()->route('ac$activity.list')->with('success', 'Berhasil menghapus aktivitas!');
    }
}
