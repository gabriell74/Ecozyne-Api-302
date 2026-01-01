<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comic;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional5Test extends TestCase
{
    // Fungsional 5.1

    // TC-001
    public function test_comic_is_sucessfully_created(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan validasi yang benar
        $input = [
            'comic_title' => 'Mico & Lobak',
            'cover_photo' => UploadedFile::fake()->image('Cover_komik.jpg'),
            'photo'       => UploadedFile::fake()->image('Foto_komik.jpg'),
        ];

        $response = $this->post('/comic/store', $input);

        $comic = Comic::latest('id')->first();
        $this->assertDatabaseHas('comic', [
            'id' => $comic->id,
        ]);
    }

    // TC-002
    public function test_comic_is_fail_to_created_invalid_comic_title(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan judul komik lebih dari 255 karakter
        $input = [
            'comic_title' => str_repeat('Mico & Lobak', 25),
            'cover_photo' => UploadedFile::fake()->image('Cover_komik.jpg'),
            'photo'       => UploadedFile::fake()->image('Foto_komik.jpg'),
        ];

        $response = $this->post('/comic/store', $input);
        $response->assertSessionHasErrors(['comic_title']);
    }

    // TC-003
    public function test_comic_is_fail_to_created_invalid_cover_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan cover komik
        $input = [
            'comic_title' => 'Mico & Lobak',
            'cover_photo' => '',
            'photo'       => UploadedFile::fake()->image('Foto_komik.jpg'),
        ];

        $response = $this->post('/comic/store', $input);
        $response->assertSessionHasErrors(['cover_photo']);
    }

    // TC-004
    public function test_comic_is_fail_to_created_invalid_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan foto komik
        $input = [
            'comic_title' => 'Mico & Lobak',
            'cover_photo' => UploadedFile::fake()->image('Cover_komik.jpg'),
            'photo'       => '',
        ];

        $response = $this->post('/comic/store', $input);
        $response->assertSessionHasErrors(['photo']);
    }
}
