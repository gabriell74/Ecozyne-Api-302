<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reward;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional8Test extends TestCase
{
    // Fungsional 8.1

    // TC-001
    public function test_reward_is_sucessfully_created(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan validasi yang benar
        $input = [
            'reward_name' => 'Minyak goreng',
            'photo' => UploadedFile::fake()->image('Minyakgoreng.jpg'),
            'stock' => '30',
            'unit_point' => '50',
        ];

        $response = $this->post('/reward/store', $input);

        $reward = Reward::latest('id')->first();
        $this->assertDatabaseHas('reward', [
            'id' => $reward->id,
        ]);
    }

    // TC-002
    public function test_reward_is_fail_to_created_invalid_reward_name(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan panjang nama hadiah lebih dari 255 karakter
        $input = [
            'reward_name' => str_repeat('Minyak goreng', 20),
            'photo' => UploadedFile::fake()->image('Minyakgoreng.jpg'),
            'stock' => '30',
            'unit_point' => '50',
        ];

        $response = $this->post('/reward/store', $input);
        $response->assertSessionHasErrors(['reward_name']);
    }

    // TC-003
    public function test_reward_is_fail_to_created_invalid_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan foto
        $input = [
            'reward_name' => 'Minyak goreng',
            'photo' => '',
            'stock' => '30',
            'unit_point' => '50',
        ];

        $response = $this->post('/reward/store', $input);
        $response->assertSessionHasErrors(['photo']);
    }

    // TC-004
    public function test_reward_is_fail_to_created_invalid_stock(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan stock
        $input = [
            'reward_name' => 'Minyak goreng',
            'photo' => UploadedFile::fake()->image('Minyakgoreng.jpg'),
            'stock' => '',
            'unit_point' => '50',
        ];

        $response = $this->post('/reward/store', $input);
        $response->assertSessionHasErrors(['stock']);
    }

    // TC-004
    public function test_reward_is_fail_to_created_invalid_unit_point(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan harga poin
        $input = [
            'reward_name' => 'Minyak goreng',
            'photo' => UploadedFile::fake()->image('Minyakgoreng.jpg'),
            'stock' => '30',
            'unit_point' => '',
        ];

        $response = $this->post('/reward/store', $input);
        $response->assertSessionHasErrors(['unit_point']);
    }

}
