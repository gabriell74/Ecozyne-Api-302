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
            $token = $user->createToken('auth-token')->plainTextToken;

            activity()
                ->causedBy($user)
                ->performedOn($user)
                ->event('login-success')
                ->withProperties([
                    'email' => $user->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('User berhasil login');

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'token' => $token,
            ]);
        }

        activity()
            ->event('login-failed')
            ->withProperties([
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('Percobaan login gagal');

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }
}