<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Point;
use App\Models\Address;
use App\Mail\SendOtpMail;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                $request->validate([
                    'username' => 'required',
                    'name' => 'required',
                    'email' => 'required|email',
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
                    'phone_number' => [
                        'required',
                        'min:10',
                        'regex:/^[0-9]+$/'
                    ],
                    'address' => 'required',
                    'postal_code' => 'required',
                    'kelurahan' => 'required',
                ]);

                $email = strtolower($request->email);

                $existingUnverifiedUser = User::where('email', $email)
                    ->whereNull('email_verified_at')
                    ->first();

                if ($existingUnverifiedUser) {

                    RateLimiter::clear('otp-verify:' . $email);
                    RateLimiter::clear('otp-resend:' . $email);

                    $community = $existingUnverifiedUser->community;

                    if ($community) {
                        Point::where('community_id', $community->id)->delete();
                        Address::where('id', $community->address_id)->delete();
                        $community->delete();
                    }

                    $existingUnverifiedUser->delete();
                }

                if (User::where('email', $email)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email sudah terdaftar',
                    ], 409);
                }

                $otpCode = rand(100000, 999999);

                $address = Address::create([
                    'address' => $request->address,
                    'kelurahan_id' => $request->kelurahan,
                    'postal_code' => $request->postal_code,
                ]);

                $user = User::create([
                    'username' => $request->username,
                    'email' => $email,
                    'password' => Hash::make($request->password),
                    'otp_code' => $otpCode,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                $community = Community::create([
                    'user_id' => $user->id,
                    'address_id' => $address->id,
                    'phone_number' => $request->phone_number,
                    'name' => $request->name,
                ]);

                Point::create([
                    'community_id' => $community->id,
                    'expired_point' => now()->addYear(),
                ]);

                Mail::to($user->email)->send(new SendOtpMail($otpCode));

                activity()
                    ->causedBy($user)
                    ->performedOn($user)
                    ->event('register')
                    ->withProperties([
                        'email' => $user->email,
                        'community' => $community->name,
                        'phone_number' => $community->phone_number
                    ])
                    ->log('User melakukan registrasi dan menunggu verifikasi');

                return response()->json([
                    'email' => $user->email,
                    'success' => true,
                    'message' => 'Pendaftaran berhasil, silakan verifikasi OTP',
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
                'message' => 'Pendaftaran gagal, silakan coba lagi',
            ], 500);
        }
    }


    public function registerOtpVerify(Request $request)
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

                if ($user->email_verified_at) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email ini sudah diverifikasi',
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
                    'email_verified_at' => now(),
                    'otp_code' => null,
                    'otp_expires_at' => null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi berhasil, silakan login',
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

    public function resendOtp(Request $request)
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
                ->whereNull('email_verified_at')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun sudah diverifikasi atau tidak ditemukan',
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

   public function getProfile(Request $request)
    {
        $user = $request->user();

        $responseUser = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
        ];

        $community = Community::with([
            'address:id,address,postal_code,kelurahan_id',
            'address.kelurahan:id,kelurahan,kecamatan_id',
            'address.kelurahan.kecamatan:id,kecamatan',
            'point:id,community_id,point,expired_point',
        ])
        ->where('user_id', $user->id)
        ->select('id','user_id','address_id','photo','phone_number','name')
        ->first();

        if ($community) {
            $responseUser['community'] = [
                'name' => $community->name,
                'phone_number' => $community->phone_number,
                'address' => [
                    'address' => $community->address->address ?? null,
                    'postal_code' => $community->address->postal_code ?? null,
                    'kelurahan' => $community->address->kelurahan->kelurahan ?? null,
                    'kecamatan' => $community->address->kelurahan->kecamatan->kecamatan ?? null,
                ],
                'photo' => $community->photo ? asset('storage/'.$community->photo) : null,
                'point' => $community->point->point ?? 0,
                'expired_point' => $community->point->expired_point ?? null,
            ];
        }

        /* ===========================
        ROLE: WASTE BANK
        ============================*/
        if ($user->role === 'waste_bank' && $community) {

            $wasteBank = WasteBank::with([
                'wasteBankSubmission' => function($q) {
                    $q->select(
                        'id','community_id',
                        'waste_bank_name','waste_bank_location',
                        'latitude','longitude',
                        'notes',
                    );
                }
            ])
            ->whereHas('wasteBankSubmission', function($q) use ($community) {
                $q->where('community_id', $community->id);
            })
            ->first();

            if ($wasteBank && $wasteBank->wasteBankSubmission) {
                $responseUser['waste_bank'] = [
                    'id' => $wasteBank->id,
                    'waste_bank_name' => $wasteBank->wasteBankSubmission->waste_bank_name,
                    'waste_bank_location' => $wasteBank->wasteBankSubmission->waste_bank_location,
                    'latitude' => $wasteBank->wasteBankSubmission->latitude,
                    'longitude' => $wasteBank->wasteBankSubmission->longitude,
                    'notes' => $wasteBank->wasteBankSubmission->notes,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'user' => $responseUser,
        ], 200);
    }

        public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => [
                'required',
                'min:10',
                'regex:/^[0-9]+$/'
            ],
            'address' => 'required',
            'postal_code' => 'required',
            'kelurahan' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $before = [
                'username' => $user->username,
                'email' => $user->email
            ];

            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            $community = Community::where('user_id', $user->id)->first();

            if ($community) {
                $before['community'] = [
                    'name' => $community->name,
                    'phone_number' => $community->phone_number,
                ];

                $community->update([
                    'name' => $validated['name'],
                    'phone_number' => $validated['phone_number'],
                ]);
            }

            DB::commit();

            /** ACTIVITY LOG */
            activity()
                ->causedBy($user)
                ->performedOn($user)
                ->event('update_profile')
                ->withProperties([
                    'before' => $before,
                    'after' => $validated,
                ])
                ->log('User memperbarui profil');

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
            ], 200);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil',
            ], 500);
        }
    }
}