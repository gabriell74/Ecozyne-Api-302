<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ResetPasswordController extends Controller
{
    public function sendOtpForResetPassword(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $request->validate([
                    'email' => 'required|email',
                ]);

                $email = strtolower($request->email);
                $user = User::where('email', $email)->first();

                if (!$user) {
                    RateLimiter::clear('otp-verify:' . $email);
                    RateLimiter::clear('otp-resend:' . $email);

                    return response()->json([
                        'success' => false,
                        'message' => 'Pengguna Tidak Ditemukan'
                    ], 404);
                }

                if (is_null($user->email_verified_at)) {
                    RateLimiter::clear('otp-verify:' . $email);
                    RateLimiter::clear('otp-resend:' . $email);

                    return response()->json([
                        'success' => false,
                        'message' => 'Email belum diverifikasi, silahkan registrasi ulang.'
                    ], 403);
                }

                $otpCode = rand(100000, 999999);
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => now()->addMinutes(10)
                ]);

                Mail::to($user->email)->send(new SendOtpMail($otpCode));

                activity()
                    ->causedBy($user)
                    ->performedOn($user)
                    ->event('Forgot Password')
                    ->withProperties([
                        'email' => $user->email,
                    ])
                    ->log('User sedang proses mereset password');

                return response()->json([
                    'email' => $user->email,
                    'success' => true,
                    'message' => 'OTP Dikirim, silahkan cek email anda.',
                ], 200);
            });

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'OTP Gagal dikirim, silahkan coba lagi',
            ], 500);
        }
    }

    public function resetPasswordOtpVerify(Request $request) 
    {
        try {
            return DB::transaction(function () use ($request) {

                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'otp' => 'required|numeric|digits:6'
                ]);

                $email = strtolower($request->email);
                $rateLimitKey = 'otp-verify:' . $email;

                if (RateLimiter::tooManyAttempts($rateLimitKey, 8)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terlalu banyak percobaan OTP. Silakan coba lagi nanti.',
                    ], 429);
                }

                RateLimiter::hit($rateLimitKey, 600);

                $user = User::where('email', $email)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$user->email_verified_at) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email belum diverifikasi, silahkan registrasi ulang.',
                    ], 409);
                }

                if ($user->otp_code !== $request->otp) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode OTP salah',
                    ], 400);
                }

                if (now()->gt($user->otp_expires_at)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kode OTP sudah kadaluarsa',
                    ], 410);
                }

                RateLimiter::clear($rateLimitKey);

                $user->update([
                    'otp_code' => null,
                    'otp_expires_at' => null,
                ]);

                return response()->json([
                    'email' => $user->email,
                    'success' => true,
                    'message' => 'Verifikasi berhasil, silahkan masukkan password baru',
                ], 201);
            });

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi gagal, silakan coba lagi',
            ], 500);
        }
    }

    public function resetPasswordResendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $email = strtolower($request->email);
            $rateLimitKey = 'otp-resend:' . $email;

            if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak permintaan OTP. Silakan coba lagi nanti.',
                ], 429);
            }

            RateLimiter::hit($rateLimitKey, 300);

            $user = User::where('email', $email)
                ->whereNotNull('email_verified_at')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email belum diverifikasi, silahkan registrasi ulang.',
                ], 400);
            }

            $otpCode = rand(100000, 999999);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            RateLimiter::clear('otp-verify:' . $email);

            Mail::to($user->email)->send(new SendOtpMail($otpCode));

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah dikirim',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulang OTP',
            ], 500);
        }
    }

    public function resetPasswordByUser(Request $request) 
    {   
        try { 
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'password' => [
                        'required',
                        'string',
                        'min:8',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*?&._\-]/',
                        'not_regex:/\s/',
                    ],
                    'password_confirmation' => [
                        'required',
                        'same:password',
                        'string',
                        'min:8',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*?&._\-]/',
                        'not_regex:/\s/',
                    ],
                ]);

                $user = User::where('email', $request->email)->lockForUpdate()->firstOrFail();
                
                if (Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password baru tidak boleh sama dengan yang lama',
                    ], 400);
                }

                $user->password = Hash::make($request->password);
                $user->otp_code = null;
                $user->otp_expires_at = null;
                $user->save();
            });

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi gagal, silakan coba lagi',
            ], 500);
        }
    }
}


