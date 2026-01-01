<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Fungsional1Test extends TestCase
{
    // TC-001
    public function test_user_is_sucessfully_login_to_app(): void
    {
        // Input
        $input = [
            'email' => 'iniemail616@gmail.com',
            'password' => '@Yusril123'
        ];

        $response = $this->postJson('api/login', $input);
        $response->assertStatus(200);
    }

    public function test_user_is_fail_to_login_email_not_registered(): void
    {
        // Input dengan email salah atau tidak terdaftar
        $input = [
            'email' => 'iiiiniemail616@gmail.com',
            'password' => '@Yusril123'
        ];

        $response = $this->postJson('api/login', $input);
        $response->assertStatus(401);
    }

    // TC-002
    public function test_user_is_fail_to_login_wrong_password(): void
    {
        // Input dengan password salah
        $input = [
            'email' => 'iniemail616@gmail.com',
            'password' => '@Yusril1233333'
        ];

        $response = $this->postJson('api/login', $input);

        $response->assertStatus(401);
    }
}
