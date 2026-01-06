<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional6Test extends TestCase
{
    // Fungsional 6.1

    // TC-001
    public function test_activity_is_sucessfully_created(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan validasi yang benar
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);

        $activity = Activity::latest('id')->first();
        $this->assertDatabaseHas('activity', [
            'id' => $activity->id,
        ]);
    }

    // TC-002
    public function test_activity_is_fail_to_created_invalid_title(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan judul
        $input = [
            'title' => '',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['title']);
    }

    // TC-003
    public function test_activity_is_fail_to_created_invalid_description(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan deskripsi
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => '',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['description']);
    }
    
    // TC-004
    public function test_activity_is_fail_to_created_invalid_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan foto
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => '',
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['photo']);
    }

    // TC-005
    public function test_activity_is_fail_to_created_invalid_location(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan lokasi
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => '',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['location']);
    }

    // TC-006
    public function test_activity_is_fail_to_created_invalid_quota(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan kuota
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['quota']);
    }

    // TC-007
    public function test_activity_is_fail_to_created_invalid_start_date(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan tanggal mulai
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['start_date']);
    }

    // TC-008
    public function test_activity_is_fail_to_created_invalid_due_date(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan judul
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['due_date']);
    }

    // TC-009
    public function test_activity_is_fail_to_created_invalid_registration_start_date(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan tanggal pembukaan pendaftaran
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '',
            'registration_due_date' => '2025-10-28',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['registration_start_date']);
    }

    // TC-010
    public function test_activity_is_fail_to_created_invalid_registration_due_date(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan judul
        $input = [
            'title' => 'Meet & greet komunitas eco enzyme',
            'description' => 'Kami mengajak seluruh komunitas eco enzyme untuk meet & greet',
            'photo' => UploadedFile::fake()->image('Meetgreet.jpg'),
            'location' => 'Lapangan Bt Aji',
            'quota' => '30',
            'start_date' => '2025-11-1',
            'due_date' => '2025-11-3',
            'registration_start_date' => '2025-10-27',
            'registration_due_date' => '',
        ];

        $response = $this->post('/activity/store', $input);
        $response->assertSessionHasErrors(['registration_due_date']);
    }
    
}
