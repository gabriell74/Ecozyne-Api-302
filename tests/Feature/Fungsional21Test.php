<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional21Test extends TestCase
{
    // TC-001
    public function test_eco_enzyme_tracking_is_sucessfully_created(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'batch_name' => 'Eco Enzyme Pertama',
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-05',
            'notes' => 'Projek Eco Enzyme Pertama',
        ];

        $response = $this->postJson('api/eco-enzyme-tracking/store-batch', $input);
        $response->assertStatus(201);
    }

    // TC-002
    public function test_eco_enzyme_tracking_is_fail_to_created_invalid_batch_name(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan nama batch lebih dari 255 karakter
        $input = [
            'batch_name' => str_repeat('Eco Enzyme Pertama', 15),
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-05',
            'notes' => 'Projek Eco Enzyme Pertama',
        ];

        $response = $this->postJson('api/eco-enzyme-tracking/store-batch', $input);
        $response->assertStatus(422);
    }

    // TC-003
    public function test_eco_enzyme_tracking_is_fail_to_created_invalid_start_date(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan tanggal mulai
        $input = [
            'batch_name' => 'Eco Enzyme Pertama',
            'start_date' => '',
            'end_date' => '2026-01-05',
            'notes' => 'Projek Eco Enzyme Pertama',
        ];

        $response = $this->postJson('api/eco-enzyme-tracking/store-batch', $input);
        $response->assertStatus(422);
    }

    // TC-004
    public function test_eco_enzyme_tracking_is_fail_to_created_invalid_end_date(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan tanggal selesai
        $input = [
            'batch_name' => 'Eco Enzyme Pertama',
            'start_date' => '2026-01-01',
            'end_date' => '',
            'notes' => 'Projek Eco Enzyme Pertama',
        ];

        $response = $this->postJson('api/eco-enzyme-tracking/store-batch', $input);
        $response->assertStatus(422);
    }

    // TC-005
    public function test_eco_enzyme_tracking_is_fail_to_created_invalid_notes(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan catatan
        $input = [
            'batch_name' => 'Eco Enzyme Pertama',
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-05',
            'notes' => '',
        ];

        $response = $this->postJson('api/eco-enzyme-tracking/store-batch', $input);
        $response->assertStatus(422);
    }

}
