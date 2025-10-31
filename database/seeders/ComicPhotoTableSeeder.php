<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ComicPhotoTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            DB::table('comic_photo')->insert([
                'comic_id' => $faker->numberBetween(1, 5),
                'photo' => 'comic_page_' . $i . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}