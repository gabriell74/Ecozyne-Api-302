<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ComicTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $comics = [
            'Petualangan Ecozyne: Menyelamatkan Bumi',
            'Sampah Bukan Musuh',
            'Kisah Si Botol Plastik',
            'Daur Ulang itu Seru!',
            'Komposter Cilik'
        ];

        foreach ($comics as $comic) {
            DB::table('comic')->insert([
                'comic_title' => $comic,
                'cover_photo' => 'foto',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}