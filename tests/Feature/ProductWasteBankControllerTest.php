<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductWasteBankControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200_get_all_mengambil_semua_produk_yang_dimiliki_bank_sampah()
    {
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Hitung total data di database
        $totalData = Product::where('id', $user->community->wasteBankSubmission->wasteBank->id)->count();

        // Memastikan statusnya 200 atau OK
        $response = $this->get('/api/waste-bank/products');
        $response->assertStatus(200);

        // Ambil JSON respon
        $data = $response->json('data') ?? $response->json();

        // Pastikan JSON berupa array
        $this->assertIsArray($data, 'Response data bukan array.');

        // Bandingkan jumlah data JSON dan database
        $this->assertEquals($totalData, count($data), 'Jumlah data dari API tidak sesuai database.');
    }
}
