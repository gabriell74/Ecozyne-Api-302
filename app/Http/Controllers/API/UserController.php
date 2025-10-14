<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Point;
use App\Models\Address;
use App\Models\Community;
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
            $validated = $request->validate([
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'phone_number' => 'required|min:10',
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
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal',
            ], 500);
        }
    }

    public function editProfile(Request $request)
    {
         $validated = $request->validate([
                'username' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'phone_number' => 'required|min:10',
                'address' => 'required',
                'postal_code' => 'required',
                'kelurahan' => 'required',
         ]);
    }
}