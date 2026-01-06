<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Fungsional14Test extends TestCase
{
    // TC-001
    public function test_submission_is_sucessfully_stored(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input yang valid
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(201);
    }

    // TC-002
    public function test_submission_is_fail_to_stored_invalid_waste_bank_name(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan nama bank sampah lebih dari 255 karakter
        $input = [
            'waste_bank_name' => str_repeat('SeiPanasEcoEnzyme', 20),
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-003
    public function test_submission_is_fail_to_stored_invalid_waste_bank_location(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan lokasi bank sampah lebih dari 300 karakter
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => str_repeat('Sungai Panas Jl Jeruk', 15),
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-004
    public function test_submission_is_fail_to_stored_invalid_latitude(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan mengosongkan latitude
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-005
    public function test_submission_is_fail_to_stored_invalid_longtitude(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan mengosongkan longtitude
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-006
    public function test_submission_is_fail_to_stored_invalid_notes(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan mengosongkan catatan
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => '',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-007
    public function test_submission_is_fail_to_stored_invalid_photos(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan mengosongkan foto
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => '',
            'file_document' => UploadedFile::fake()->create('Pengajuan.pdf', 500, 'application/pdf'),
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }

    // TC-008
    public function test_submission_is_fail_to_stored_invalid_file_document(): void
    {
        $user = User::findOrFail(34);
        $this->actingAs($user);

        // Input dengan mengosongkan file document
        $input = [
            'waste_bank_name' => 'SeiPanasEcoEnzyme',
            'waste_bank_location' => 'Sungai Panas Jl Jeruk',
            'latitude' => '1.1643',
            'longitude' => '104.0244',
            'notes' => 'Saya ingin menjadi bank sampah',
            'photo' => UploadedFile::fake()->image('Pengajuan.jpg'),
            'file_document' => '',
        ];

        $response = $this->postJson('api/waste-bank-submission/store', $input);
        $response->assertStatus(422);
    }
}
