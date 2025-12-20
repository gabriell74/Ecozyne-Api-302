<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HahayController extends Controller
{

    public function register(Request $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $existingUnverifiedUser = User::where('email', $request->email)
                    ->whereNull('email_verified_at')
                    ->first();

                if ($existingUnverifiedUser) {
                    $existingUnverifiedUser->delete();
                }

                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => [
                        'required',
                        'confirmed',
                        PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
                    ]
                ]);

                $otpCode = rand(100000, 999999);
                
                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'role' => 'user',
                    'otp_code' => $otpCode,
                    'otp_expires_at' => Carbon::now()->addMinutes(10),
                ]);

                Mail::to($user->email)->send(new SendOtpMail($otpCode, 'emails.registration_otp', 'Kode Verifikasi Akun Anda'));

                Log::info('[API AuthController@register] Sukses: Registrasi berhasil.');

                return $this->sendSuccess(
                    'Registrasi berhasil! Cek email Anda untuk kode OTP.',
                    ['email' => $user->email],
                    201
                );
            });

        } catch (ValidationException $e) {
            Log::warning('[API AuthController@register] Gagal: Validasi error.', ['errors' => $e->errors()]);
            return $this->sendValidationError($e);
        } catch (\Exception $e) {
            Log::error('[API AuthController@register] Gagal: Error sistem.', ['error' => $e->getMessage()]);
            return $this->sendError('Terjadi kesalahan pada server.', 500);
        }
    }

    /**
     * Memverifikasi OTP Registrasi.
     * * @param Request $request
     * @return JsonResponse
     */
    public function registerOtpVerify(Request $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'email' => 'required|email|exists:users,email',
                    'otp' => 'required|numeric|digits:6'
                ]);

                $user = User::where('email', $request->email)->lockForUpdate()->firstOrFail();

                if ($user->hasVerifiedEmail()) {
                    Log::warning('[API AuthController@registerOtpVerify] Gagal: Email sudah terverifikasi.');
                    return $this->sendError('Email ini sudah terverifikasi.', 400);
                }

                if ($user->otp_code != $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
                    Log::warning('[API AuthController@registerOtpVerify] Gagal: Kode OTP salah atau kedaluwarsa.');
                    return $this->sendError('Kode OTP salah atau telah kedaluwarsa.', 422);
                }

                $user->email_verified_at = now();
                $user->otp_code = null;
                $user->otp_expires_at = null;
                $user->save();

                $token = $user->createToken('auth_token')->plainTextToken;

                Log::info('[API AuthController@registerOtpVerify] Sukses: Verifikasi OTP berhasil.');

                return $this->sendSuccess('Verifikasi berhasil! Selamat datang.', [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $this->formatUser($user)
                ]);
            });

        } catch (ValidationException $e) {
            Log::warning('[API AuthController@registerOtpVerify] Gagal: Validasi error.', ['errors' => $e->errors()]);
            return $this->sendValidationError($e);
        } catch (\Exception $e) {
            Log::error('[API AuthController@registerOtpVerify] Gagal: Error sistem.', ['error' => $e->getMessage()]);
            return $this->sendError('Terjadi kesalahan sistem.', 500);
        }
    }
}
