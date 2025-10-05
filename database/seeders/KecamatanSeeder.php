<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kecamatan::insert([
            ['id' => 1, 'kecamatan' => 'Batam Kota'],
            ['id' => 2, 'kecamatan' => 'Batu Aji'],
            ['id' => 3, 'kecamatan' => 'Batu Ampar'],
            ['id' => 4, 'kecamatan' => 'Belakang Padang'],
            ['id' => 5, 'kecamatan' => 'Bengkong'],
            ['id' => 6, 'kecamatan' => 'Bulang'],
            ['id' => 7, 'kecamatan' => 'Galang'],
            ['id' => 8, 'kecamatan' => 'Lubuk Baja'],
            ['id' => 9, 'kecamatan' => 'Nongsa'],
            ['id' => 10, 'kecamatan' => 'Sagulung'],
            ['id' => 11, 'kecamatan' => 'Sei Beduk'],
            ['id' => 12, 'kecamatan' => 'Sekupang'],
        ]);
    }
}
