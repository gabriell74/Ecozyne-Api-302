<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function sendOtpForResetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $email = strtolower($request->email);

            $user = User::where('email', $email)
                ->whereNotNull('email_verified_at')
                ->first();

            if (!$user) {
                RateLimiter::clear('otp-verify:' . $email);
                RateLimiter::clear('otp-resend:' . $email);

                return response()->json([
                    'success' => false,
                    'message' => "Email tidak ditemukan \n atau belum diverifikasi",
                ], 404);
            }

            $otpCode = rand(100000, 999999);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(10),
                'reset_password_verified_at' => null,
            ]);

            Mail::to($user->email)->send(new SendOtpMail($otpCode));

            return response()->json([
                'success' => true,
                'email' => $user->email,
                'message' => 'OTP dikirim untuk reset password',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP reset password',
            ], 500);
        }
    }

    public function resetPasswordOtpVerify(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'otp' => 'required|digits:6',
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
                        'message' => 'Email belum diverifikasi',
                    ], 403);
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
                    'reset_password_verified_at' => now(),
                    'otp_code' => null,
                    'otp_expires_at' => null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP valid, silakan reset password',
                ], 200);
            });

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi OTP gagal',
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
                    'message' => 'Email belum diverifikasi',
                ], 403);
            }

            $otpCode = rand(100000, 999999);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => now()->addMinutes(10),
                'reset_password_verified_at' => null,
            ]);

            RateLimiter::clear('otp-verify:' . $email);

            Mail::to($user->email)->send(new SendOtpMail($otpCode));

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah dikirim',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
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
                    'password_confirmation' => 'required|same:password',
                ]);

                $user = User::where('email', $request->email)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$user->reset_password_verified_at) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP belum diverifikasi',
                    ], 403);
                }

                if (Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password baru tidak boleh sama dengan password lama',
                    ], 400);
                }

                $user->update([
                    'password' => Hash::make($request->password),
                    'reset_password_verified_at' => null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Password berhasil direset',
                ], 200);
            });

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reset password gagal',
            ], 500);
        }
    }
}