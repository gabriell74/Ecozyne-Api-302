<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{   
    public function komunitas()
    {
        return view('admin.komunitas');
    }
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('admin.profile'); 
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); 

        // 1. Validasi Input
        $request->validate([
            'nama_asli' => ['required', 'string', 'max:255'],
            'nama_pengguna' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'no_hp' => ['nullable', 'string', 'max:15'], 
            'alamat' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'], 
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        // 2. Update Data Dasar
        $user->name = $request->nama_asli;
        $user->username = $request->nama_pengguna; 
        $user->email = $request->email;
        $user->phone_number = $request->no_hp; 
        $user->address = $request->alamat;     

        // 3. Update Password (jika diisi)
        if ($request->filled('password')) { 
            $user->password = Hash::make($request->password);
        }

        // 4. Update Avatar (jika ada file diupload)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}


?>
