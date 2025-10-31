<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GalleryTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 12; $i++) {
            DB::table('gallery')->insert([
                'photo' => 'gallery_' . $i . '.jpg',
                'description' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}