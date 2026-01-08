<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional17Test extends TestCase
{
    // TC-001
    public function test_product_is_sucessfully_created(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'product_name' => 'Eco Enzyme 500ml',
            'description' => 'Berisi eco enzyme yang sudah jadi dengan volume 500ml',
            'price' => '50000',
            'stock' => '10',
            'photo' => UploadedFile::fake()->image('Eco_enzyme.jpg'),
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(201);
    }

    // TC-002
    public function test_product_is_fail_to_created_invalid_product_name(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan nama produk lebih dari 255 karakter
        $input = [
            'product_name' => str_repeat('Eco Enzyme 500ml', 20),
            'description' => 'Berisi eco enzyme yang sudah jadi dengan volume 500ml',
            'price' => '50000',
            'stock' => '10',
            'photo' => UploadedFile::fake()->image('Eco_enzyme.jpg'),
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(422);
    }

    // TC-003
    public function test_product_is_fail_to_created_invalid_description(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan deskripsi
        $input = [
            'product_name' => 'Eco Enzyme 500ml',
            'description' => '',
            'price' => '50000',
            'stock' => '10',
            'photo' => UploadedFile::fake()->image('Eco_enzyme.jpg'),
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(422);
    }

    // TC-004
    public function test_product_is_fail_to_created_invalid_price(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan harga
        $input = [
            'product_name' => 'Eco Enzyme 500ml',
            'description' => 'Berisi eco enzyme yang sudah jadi dengan volume 500ml',
            'price' => '',
            'stock' => '10',
            'photo' => UploadedFile::fake()->image('Eco_enzyme.jpg'),
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(422);
    }

    // TC-005
    public function test_product_is_fail_to_created_invalid_stock(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input dengan mengosongkan stok
        $input = [
            'product_name' => 'Eco Enzyme 500ml',
            'description' => 'Berisi eco enzyme yang sudah jadi dengan volume 500ml',
            'price' => '50000',
            'stock' => '',
            'photo' => UploadedFile::fake()->image('Eco_enzyme.jpg'),
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(422);
    }

    // TC-006
    public function test_product_is_fail_to_created_invalid_photo(): void
    {
        $user = User::findOrFail(31);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'product_name' => 'Eco Enzyme 500ml',
            'description' => 'Berisi eco enzyme yang sudah jadi dengan volume 500ml',
            'price' => '50000',
            'stock' => '10',
            'photo' => '',
        ];

        $response = $this->postJson('api/waste-bank/products/create', $input);
        $response->assertStatus(422);
    }
}
