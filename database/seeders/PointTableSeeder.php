<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PointTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            DB::table('point')->insert([
                'community_id' => $i,
                'point' => $faker->numberBetween(0, 1000),
                'expired_point' => $faker->dateTimeBetween('+3 months', '+1 year')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}