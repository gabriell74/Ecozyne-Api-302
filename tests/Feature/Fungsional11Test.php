<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional11Test extends TestCase
{
    // TC-001
    public function test_user_is_sucessfully_updated(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(200);
    }

    // TC-002
    public function test_user_is_fail_to_updated_invalid_username(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan username lebih dari 255 karakter
        $input = [  
            'username' => str_repeat('Yusril123', 30),
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-003
    public function test_user_is_fail_to_updated_invalid_name(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan nama lebih dari 255 karakter
        $input = [  
            'username' => 'Yusril123',
            'name' => str_repeat('Yusril Nafis Taulany', 15),
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-004
    public function test_user_is_fail_to_updated_invalid_email(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan email yang sudah terdaftar
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'iniemail616@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-005
    public function test_user_is_fail_to_updated_invalid_phone_number(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan nomor handphone
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-006
    public function test_user_is_fail_to_updated_invalid_address(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan alamat
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => '',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-007
    public function test_user_is_fail_to_updated_invalid_postal_code(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan kode pos
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '',
            'kelurahan' => '1',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-008
    public function test_user_is_fail_to_updated_invalid_kecamatan(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan kecamatan
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }

    // TC-009
    public function test_user_is_fail_to_updated_invalid_kelurahan(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan kelurahan
        $input = [  
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '',
        ];

        $response = $this->putJson('api/update-profile', $input);
        $response->assertStatus(422);
    }
}
