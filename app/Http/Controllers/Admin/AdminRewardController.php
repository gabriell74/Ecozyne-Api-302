<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewards = Reward::latest()->get(); 

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
            'reward_name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:8192',
            'stock' => 'required',
            'unit_point' => 'required',
        ]);

        $path = $request->file('photo')->store('reward', 'public');

        Reward::create([
            'reward_name' => $request->reward_name,
            'description' => $request->description,
            'photo' => $path,
            'stock' => $request->stock,
            'unit_point' => $request->unit_point,     
        ]);

        return redirect()->route('reward.list')->with('success', 'Berhasil menambah hadiah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
