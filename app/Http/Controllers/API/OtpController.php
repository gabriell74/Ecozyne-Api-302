<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) return response()->json([
            'success' => false,
            'message' => 'Pengguna Tidak Ditemukan'
        ], 404);

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        // Kirim lewat email / SMS
        Mail::to($user->email)->send(new SendOtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP Dikirim',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp_code' => 'required']);
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp_code != $request->otp_code)
            return response()->json([
                'success' => false,
                'message' => 'OTP Salah'
            ], 400);

        if (now()->greaterThan($user->otp_expires_at))
            return response()->json([
                'success' => false,
                'message' => 'OTP Kadaluarsa'
            ], 400);

        // Reset OTP setelah sukses
        $user->update([
            'otp_code' => null, 
            'otp_expires_at' => null,
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi Akun Berhasil!'
        ]);
    }
}

