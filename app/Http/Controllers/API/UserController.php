<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Point;
use App\Models\Address;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',      // huruf kecil
                    'regex:/[A-Z]/',      // huruf besar
                    'regex:/[0-9]/',      // angka
                    'regex:/[@$!%*?&._\-]/', // simbol
                    'not_regex:/\s/', // tanpa spasi
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

            DB::beginTransaction();

            $address = Address::create([
                'address' => $request->address,
                'kelurahan_id' => $request->kelurahan,
                'postal_code' => $request->postal_code,
            ]);
            
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $community = Community::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'phone_number' => $request->phone_number,
                'name' => $request->name,
            ]);

            Point::create([
                'community_id' => $community->id,
                'expired_point'=> now()->addYear(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran Berhasil',
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal',
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
                        'file_document','notes',
                    );
                }
            ])
            ->whereHas('wasteBankSubmission', function($q) use ($community) {
                $q->where('community_id', $community->id);
            })
            ->first();

            if ($wasteBank && $wasteBank->wasteBankSubmission) {
                $responseUser['waste_bank'] = [
                    'waste_bank_name' => $wasteBank->wasteBankSubmission->waste_bank_name,
                    'waste_bank_location' => $wasteBank->wasteBankSubmission->waste_bank_location,
                    'latitude' => $wasteBank->wasteBankSubmission->latitude,
                    'longitude' => $wasteBank->wasteBankSubmission->longitude,
                    'file_document' => $wasteBank->wasteBankSubmission->file_document,
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
            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            $community = Community::where('user_id', $user->id)->first();
            if ($community) {
                $community->update([
                    'name' => $validated['name'],
                    'phone_number' => $validated['phone_number'],
                ]);

                $address = Address::find($community->address_id);
                if ($address) {
                    $address->update([
                        'address' => $validated['address'],
                        'postal_code' => $validated['postal_code'],
                        'kelurahan_id' => $validated['kelurahan'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        }  catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil',
            ], 500);
        }
    }

}