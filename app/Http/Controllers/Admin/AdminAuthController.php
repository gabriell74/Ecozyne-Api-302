<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function loginPage() 
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('admin.login');
    }
    
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Email tidak terdaftar
            return back()->withErrors([
                'email' => 'Email salah',
            ])->onlyInput('email');
        }

        // Cek apakah password cocok
        if (!Hash::check($request->password, $user->password)) {
            // Password salah
            return back()->withErrors([
                'password' => 'Password salah',
            ])->onlyInput('password');
        }

        // Kalau lolos semua, baru autentikasi
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Berhasil login!');
    }

    public function logout(Request $request) 
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
