<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Buat token akses untuk pengguna kalau perlu nanti tambah di json sekalian
            // $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $user,
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }
}
