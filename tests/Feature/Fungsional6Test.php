<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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
}
