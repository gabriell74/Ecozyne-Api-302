<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Fungsional2Test extends TestCase
{   
    // TC-001
    public function test_user_is_sucessfully_register(): void
    {
        // Input yang valid
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(201);
    }

    // TC-002
    public function test_user_is_fail_to_register_invalid_username(): void
    {
        // Input dengan panjang username lebih dari 255 karakter
        $input = [
            'username' => str_repeat('Yusril123', 30),
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-003
    public function test_user_is_fail_to_register_invalid_name(): void
    {
        // Input dengan panjang nama lebih dari 255 karakter
        $input = [
            'username' => 'Yusril123',
            'name' => str_repeat('Yusril Nafis Taulany', 13),
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-004
    public function test_user_is_fail_to_register_invalid_email(): void
    {
        // Input dengan email yang sudah terdaftar
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'iniemail616@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(409);
    }

    // TC-005
    public function test_user_is_fail_to_register_invalid_password(): void
    {
        // Input dengan password tanpa huruf kapital
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'yusrilmysql456.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-006
    public function test_user_is_fail_to_register_invalid_phone_number(): void
    {
        // Input dengan nomor hp kurang dari 10 karakter
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '081234567',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-007
    public function test_user_is_fail_to_register_invalid_address(): void
    {
        // Input dengan mengosongkan alamat
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => '',
            'postal_code' => '12345',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-008
    public function test_user_is_fail_to_register_invalid_postal_code(): void
    {
        // Input dengan mengosongkan kode pos
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '',
            'kelurahan' => '1',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }
    
    // TC-009
    public function test_user_is_fail_to_register_invalid_kecamatan(): void
    {
        // Input dengan mengosongkan kecamatan
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }

    // TC-010
    public function test_user_is_fail_to_register_invalid_kelurahan(): void
    {
        // Input dengan mengosongkan kelurahan
        $input = [
            'username' => 'Yusril123',
            'name' => 'Yusril Nafis Taulany',
            'email' => 'egniirawan@gmail.com',
            'password' => 'Yusrilmysql123.',
            'phone_number' => '0812345678',
            'address' => 'Bengkong, Jl. Manggis',
            'postal_code' => '12345',
            'kelurahan' => '',
        ];

        $response = $this->postJson('api/register', $input);
        $response->assertStatus(422);
    }
}
