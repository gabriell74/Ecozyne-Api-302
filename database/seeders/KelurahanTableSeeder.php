<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelurahan::insert([
            // Kecamatan id 1 = Batam Kota
            ['kecamatan_id' => 1, 'kelurahan' => 'Baloi Permai'],
            ['kecamatan_id' => 1, 'kelurahan' => 'Belian'],
            ['kecamatan_id' => 1, 'kelurahan' => 'Sukajadi'],
            ['kecamatan_id' => 1, 'kelurahan' => 'Sungai Panas'],
            ['kecamatan_id' => 1, 'kelurahan' => 'Taman Baloi'],
            ['kecamatan_id' => 1, 'kelurahan' => 'Teluk Tering'],

            // Kecamatan id 2 = Batu Aji
            ['kecamatan_id' => 2, 'kelurahan' => 'Bukit Tempayang'],
            ['kecamatan_id' => 2, 'kelurahan' => 'Buliang'],
            ['kecamatan_id' => 2, 'kelurahan' => 'Kibing'],
            ['kecamatan_id' => 2, 'kelurahan' => 'Tanjung Uncang'],

            // Kecamatan id 3 = Batu Ampar
            ['kecamatan_id' => 3, 'kelurahan' => 'Batu Merah'],
            ['kecamatan_id' => 3, 'kelurahan' => 'Kampung Seraya'],
            ['kecamatan_id' => 3, 'kelurahan' => 'Sungai Jodoh'],
            ['kecamatan_id' => 3, 'kelurahan' => 'Tanjung Sengkuang'],

            // Kecamatan id 4 = Belakang Padang
            ['kecamatan_id' => 4, 'kelurahan' => 'Kasu'],
            ['kecamatan_id' => 4, 'kelurahan' => 'Pecong'],
            ['kecamatan_id' => 4, 'kelurahan' => 'Pemping'],
            ['kecamatan_id' => 4, 'kelurahan' => 'Pulau Terong'],
            ['kecamatan_id' => 4, 'kelurahan' => 'Sekanak Raya'],
            ['kecamatan_id' => 4, 'kelurahan' => 'Tanjung Sari'],

            // Kecamatan id 5 = Bengkong
            ['kecamatan_id' => 5, 'kelurahan' => 'Bengkong Indah'],
            ['kecamatan_id' => 5, 'kelurahan' => 'Bengkong Laut'],
            ['kecamatan_id' => 5, 'kelurahan' => 'Sadai'],
            ['kecamatan_id' => 5, 'kelurahan' => 'Tanjung Buntung'],

            // Kecamatan id 6 = Bulang
            ['kecamatan_id' => 6, 'kelurahan' => 'Batu Legong'],
            ['kecamatan_id' => 6, 'kelurahan' => 'Bulang Lintang'],
            ['kecamatan_id' => 6, 'kelurahan' => 'Pantai Gelam'],
            ['kecamatan_id' => 6, 'kelurahan' => 'Pulau Buluh'],
            ['kecamatan_id' => 6, 'kelurahan' => 'Setokok'],
            ['kecamatan_id' => 6, 'kelurahan' => 'Temoyong'],

            // Kecamatan id 7 = Galang
            ['kecamatan_id' => 7, 'kelurahan' => 'Air Raja'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Galang Baru'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Karas'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Pulau Abang'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Rempang Cate'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Sembulang'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Sitanjung'],
            ['kecamatan_id' => 7, 'kelurahan' => 'Subang Mas'],

            // Kecamatan id 8 = Lubuk Baja
            ['kecamatan_id' => 8, 'kelurahan' => 'Baloi Indah'],
            ['kecamatan_id' => 8, 'kelurahan' => 'Batu Selicin'],
            ['kecamatan_id' => 8, 'kelurahan' => 'Kampung Pelita'],
            ['kecamatan_id' => 8, 'kelurahan' => 'Lubuk Baja Kota'],
            ['kecamatan_id' => 8, 'kelurahan' => 'Tanjung Uma'],

            // Kecamatan id 9 = Nongsa
            ['kecamatan_id' => 9, 'kelurahan' => 'Batu Besar'],
            ['kecamatan_id' => 9, 'kelurahan' => 'Kabil'],
            ['kecamatan_id' => 9, 'kelurahan' => 'Ngenang'],
            ['kecamatan_id' => 9, 'kelurahan' => 'Sambau'],

            // Kecamatan id 10 = Sagulung
            ['kecamatan_id' => 10, 'kelurahan' => 'Sagulung Kota'],
            ['kecamatan_id' => 10, 'kelurahan' => 'Sungai Binti'],
            ['kecamatan_id' => 10, 'kelurahan' => 'Sungai Langkai'],
            ['kecamatan_id' => 10, 'kelurahan' => 'Sungai Lekop'],
            ['kecamatan_id' => 10, 'kelurahan' => 'Sungai Pelunggut'],
            ['kecamatan_id' => 10, 'kelurahan' => 'Tembesi'],

            // Kecamatan id 11 = Sei Beduk
            ['kecamatan_id' => 11, 'kelurahan' => 'Duriangkang'],
            ['kecamatan_id' => 11, 'kelurahan' => 'Mangsang'],
            ['kecamatan_id' => 11, 'kelurahan' => 'Muka Kuning'],
            ['kecamatan_id' => 11, 'kelurahan' => 'Tanjung Piayu'],

            // Kecamatan id 12 = Sekupang
            ['kecamatan_id' => 12, 'kelurahan' => 'Patam Lestari'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Sungai Harapan'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Tanjung Pinggir'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Tanjung Riau'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Tiban Baru'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Tiban Indah'],
            ['kecamatan_id' => 12, 'kelurahan' => 'Tiban Lama'],
        ]);
    }
}
