<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Comic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComicControllerTest extends TestCase
{
    public function test_dapat_mengambil_semua_komik()
    {
        $response = $this->getJson('api/comics');
        
        $response->assertOK();
        $response->assertJson(["success" => true]);
        $response->assertJsonCount(3);
    }

    public function test_dapat_mengambil_detail_komik_by_id()
    {
        $comic = Comic::first();

        $response = $this->getJson('api/comics/' . $comic->id);
        $response->assertOK();
        $response->assertJson(["success" => true]);
        $response->assertJsonCount(3);
    }
}
