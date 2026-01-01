<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional4Test extends TestCase
{
    // Fungsional 4.1

    // TC-001
    public function test_article_is_sucessfully_created(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan validasi yang benar
        $input = [
            'title' => 'Ajakan untuk membuat eco enzyme',
            'photo' => UploadedFile::fake()->image('Artikel.jpg'),
            'description' => 'Eco enzyme adalah salah satu metode pengelolaan sampah menjadi pupuk',
        ];

        $response = $this->post('/article/store', $input);

        $article = Article::latest('id')->first();
        $this->assertDatabaseHas('article', [
            'id' => $article->id,
        ]);
    }

    // TC-002
    public function test_article_is_fail_to_created_invalid_title(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan judul
        $input = [
            'title' => '',
            'photo' => UploadedFile::fake()->image('Artikel.jpg'),
            'description' => 'Eco enzyme adalah salah satu metode pengelolaan sampah menjadi pupuk',
        ];

        $response = $this->post('/article/store', $input);
        $response->assertSessionHasErrors(['title']);
    }

    // TC-003
    public function test_article_is_fail_to_created_invalid_description(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan deskripsi
        $input = [
            'title' => 'Ajakan untuk membuat eco enzyme',
            'photo' => UploadedFile::fake()->image('Artikel.jpg'),
            'description' => '',
        ];

        $response = $this->post('/article/store', $input);
        $response->assertSessionHasErrors(['description']);
    }

    // TC-004
    public function test_article_is_fail_to_created_invalid_photo(): void
    {   
        $user = User::findOrFail(1);
        $this->actingAs($user);

        // Input dengan mengosongkan foto
        $input = [
            'title' => 'Ajakan untuk membuat eco enzyme',
            'photo' => '',
            'description' => 'Eco enzyme adalah salah satu metode pengelolaan sampah menjadi pupuk',
        ];

        $response = $this->post('/article/store', $input);

        $article = Article::latest('id')->first();
        $response->assertSessionHasErrors(['photo']);
    }
}
