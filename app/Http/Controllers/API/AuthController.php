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

            if ($user->password_expired) {
                Auth::logout();

                return response()->json([
                    'success' => false,
                    'message' => 'Password expired',
                    'data' => [
                        'id' => $user->id,
                    ]
                        
                    ], 423);  
            }

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'user' => $user,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }
}
