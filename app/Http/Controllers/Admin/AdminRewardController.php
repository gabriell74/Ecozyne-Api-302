<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllReward()
    {
        $rewards = Reward::latest()->paginate(8); 

        return view('admin.reward_list', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reward_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward_name' => 'required|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'stock' => 'required',
            'unit_point' => 'required',
        ]);

        $path = $request->file('photo')->store('reward', 'public');

        Reward::create([
            'reward_name' => $request->reward_name,
            'photo' => $path,
            'stock' => $request->stock,
            'unit_point' => $request->unit_point,     
        ]);

        return redirect()->route('reward.list')->with('success', 'Berhasil menambah hadiah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward)
    {
        return view('admin.reward_detail', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        return view('admin.reward_edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'reward_name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required',
            'unit_point' => 'required',
        ]);

        $reward->reward_name = $request->reward_name;
        $reward->stock = $request->stock;
        $reward->unit_point = $request->unit_point;

        if ($request->hasFile('photo')) {
            if ($reward->photo) {
                Storage::delete('public/' . $reward->photo);
            }

            $path = $request->file('photo')->store('reward', 'public');
            $reward->photo = $path;
        }

        $reward->save();

        return redirect()->route('reward.list')->with('success', 'Hadiah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward)
    {
        if ($reward->photo && Storage::disk('public')->exists($reward->photo)) {
            Storage::disk('public')->delete($reward->photo);
        }

        $reward->delete();

        return redirect()->route('reward.list')->with('success', 'Berhasil menghapus hadiah!');
    }
}
