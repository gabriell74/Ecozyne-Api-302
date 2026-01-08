<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional23Test extends TestCase
{
    // TC-001
    public function test_question_is_sucessfully_stored(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'question' => 'Apakah eco enzyme harus dibuka setiap hari?'
        ];

        $response = $this->postJson('api/question/store', $input);
        $response->assertStatus(201);
    }

    // TC-002
    public function test_question_is_fail_to_stored(): void
    {
        $user = User::findOrFail(33);
        $this->actingAs($user);

        // Input dengan mengosongkan pertanyaan
        $input = [
            'question' => ''
        ];

        $response = $this->postJson('api/question/store', $input);
        $response->assertStatus(422);
    }
}
