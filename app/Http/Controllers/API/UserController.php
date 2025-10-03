<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Address;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\PasswordHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Community::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'name' => $request->name,
            ]);

            Address::create([
                'address' => $request->address,
                'kelurahan_id' => $request->kelurahan,
                'postal_code' => $request->postal_code,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Pendaftaran berhasil',
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'Pendaftaran gagal',
            ]);
        }
    }

    public function changeExpiredPassword(request $request)
    {
       $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::find($request->user_id);

        // 1. Validasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah'
            ], 400);
        }

        // 2. Validasi password level 2 (strong)
        if (!$this->isStrongPassword($request->new_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password harus memenuhi level 2 (strong)',
                'requirements' => [
                    'min_length' => 8,
                    'require_uppercase' => true,
                    'require_lowercase' => true,
                    'require_numbers' => true,
                    'require_symbols' => true
                ]
            ], 400);
        }

        // 3. Validasi password history
        if ($this->isPasswordInHistory($user->id, $request->new_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password tidak boleh sama dengan password sebelumnya'
            ], 400);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
            'password_expired' => false,
            'last_password_change' => now(),
        ]);

        // Simpan ke history
        PasswordHistory::create([
            'user_id' => $user->id,
            'password_hash' => hash('sha256', $request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }

    private function isStrongPassword($password) 
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    private function isPasswordInHistory($userId, $password)
    {
        $passwordHash = hash('sha256', $password);
        return PasswordHistory::where('user_id', $userId)
                            ->where('password_hash', $passwordHash)
                            ->exists();
    }

    public function validatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Password harus diisi'
            ], 422);
        }

        $isStrong = $this->isStrongPassword($request->password);

        return response()->json([
            'success' => true,
            'data' => [
                'is_strong' => $isStrong,
                'requirements' => [
                    'min_length' => strlen($request->password) >= 8,
                    'has_uppercase' => preg_match('/[A-Z]/', $request->password),
                    'has_lowercase' => preg_match('/[a-z]/', $request->password),
                    'has_number' => preg_match('/\d/', $request->password),
                    'has_symbol' => preg_match('/[@$!%*?&]/', $request->password),
                ]
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *  
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
