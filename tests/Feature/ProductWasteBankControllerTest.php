<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class ProductWasteBankControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200_get_all_dapat_mengambil_semua_produk_yang_dimiliki_bank_sampah()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Hitung total data di database
        $waste_bank_id = $user->community->wasteBankSubmission->wasteBank->id;
        $totalData = Product::where('waste_bank_id', $waste_bank_id)->count();

        // Memastikan statusnya 200 atau OK
        $response = $this->get('/api/waste-bank/products');
        $response->assertStatus(200);
        $response->assertOK();

        // Ambil JSON respon
        $data = $response->json('data') ?? $response->json();

        // Pastikan JSON berupa array
        $this->assertIsArray($data, 'Response data bukan array.');

        // Bandingkan jumlah data JSON dan database
        $this->assertEquals($totalData, count($data), 'Jumlah data dari API tidak sesuai database.');
        $this->assertDatabaseCount('users', $totalData);
    }

    public function test_201_post_create_bank_sampah_dapat_menambah_produk()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Data
        $data = [
            'product_name' => 'Product Test Dummy',
            'description' => 'Product Test Dummy (dihapus saja)',
            'price' => '10000',
            'stock' => '20',
            'photo' => UploadedFile::fake()->image('foto.jpg')
        ];

        // Memastikan statusnya 201 atau CREATED
        $response = $this->post('/api/waste-bank/products/create', $data);
        $response->assertStatus(201);
        $response->assertCreated();
    }

    public function test_get_detail_by_id_mengambil_detail_produk_yang_dimiliki_bank_sampah() 
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Mengambil salah satu data
        $waste_bank_id = $user->community->wasteBankSubmission->wasteBank->id;
        $data = Product::where('waste_bank_id', $waste_bank_id)->first();

        // Memastikan statusnya 200 atau OK
        $response = $this->get('/api/waste-bank/products/' . $data->id);
        $response->assertStatus(200);
        $response->assertOK();

        // Ambil JSON respon
        $dataResponse = $response->json('data') ?? $response->json();

        // Pastikan JSON berupa array
        $this->assertIsArray($dataResponse, 'Response data bukan array.');
        $this->assertDatabaseHas('product', ['id' => $data->id]);
    }

    public function test_put_patch_update_bank_sampah_dapat_memperbarui_produk_miliknya()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Mengambil salah satu data untuk di tes update
        $waste_bank_id = $user->community->wasteBankSubmission->wasteBank->id;
        $data = Product::where('waste_bank_id', $waste_bank_id)->first();

        // Update Data
        $dataUpdate = [
            'product_name' => 'Product Update Test Dummy',
            'description' => 'Product Update Test Dummy (dihapus saja)',
            'price' => '10000',
            'stock' => '20'
        ];

        // Memastikan statusnya 200
        $response = $this->put('/api/waste-bank/products/' . $data->id . '/update', $dataUpdate);
        $response->assertStatus(200);
        $response->assertOK();
    }

    public function test_delete_destroy_bank_sampah_dapat_menghapus_produk_miliknya()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Mengambil salah satu data untuk di tes update
        $waste_bank_id = $user->community->wasteBankSubmission->wasteBank->id;
        $data = Product::where('waste_bank_id', $waste_bank_id)->first();

        // Memastikan statusnya 200
        $response = $this->delete('/api/waste-bank/products/' . $data->id . '/delete');
        $response->assertStatus(200);
        $response->assertOK();
    }

    public function test_validation_error_input_nama_produk_dikosongkan()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Data nama produk dikosongkan yang seharusnya diisi
        $data = [
            'product_name' => '',
            'description' => 'Product Test Dummy (dihapus saja)',
            'price' => '10000',
            'stock' => '20',
            'photo' => UploadedFile::fake()->image('foto.jpg')
        ];

        // Memastikan statusnya 422 / validasi salah
        $response = $this->postJson('/api/waste-bank/products/create', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['product_name']);
    }

    public function test_404_not_found_mengambil_endpoint_yang_salah()
    {
        // Id pengguna yang memiliki role bank sampah
        $user = User::where('id', '27')->first();

        // Memastikan menggunakan user karena perlu autentikasi
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Hitung total data di database
        $waste_bank_id = $user->community->wasteBankSubmission->wasteBank->id;
        $totalData = Product::where('waste_bank_id', $waste_bank_id)->count();

        // Route atau endpoint yang salah
        $response = $this->get('/api/waste-bank/productsssss');

        // Memastikan statusnya 404 atau NOT FOUND
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    public function test_unauthorized_peran_pengguna_bukan_bank_sampah()
    {
        // Id pengguna yang rolenya BUKAN bank sampah
        $user = User::where('id', '18')->first();

        // Memastikan user tidak kosong
        $this->assertNotNull($user, 'User tidak ditemukan di database.');
        $this->actingAs($user);

        // Mengakses route atau endpoint yang tidak diizinkan
        $response = $this->getJson('/api/waste-bank/products');
        $response->assertStatus(404);
        $response->assertNotFound();
    }
}
