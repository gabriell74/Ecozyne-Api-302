<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Gallery;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional7Test extends TestCase
{
    // Fungsional 7.1

    // TC-001
    public function test_gallery_is_sucessfully_created(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan validasi yang benar
        $input = [
            'photo' => UploadedFile::fake()->image('Foto_1.jpg'),
            'description' => 'Foto untuk halaman utama',
        ];

        $response = $this->post('/gallery/store', $input);

        $gallery = Gallery::latest('id')->first();
        $this->assertDatabaseHas('gallery', [
            'id' => $gallery->id,
        ]);
    }

    // TC-002
    public function test_gallery_is_fail_to_created_invalid_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan foto
        $input = [
            'photo' => '',
            'description' => 'Foto untuk halaman utama',
        ];

        $response = $this->post('/gallery/store', $input);
        $response->assertSessionHasErrors(['photo']);
    }

    // TC-003
    public function test_gallery_is_fail_to_created_invalid_description(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan deskripsi
        $input = [
            'photo' => UploadedFile::fake()->image('Foto_1.jpg'),
            'description' => '',
        ];

        $response = $this->post('/gallery/store', $input);
        $response->assertSessionHasErrors(['description']);
    }
}
