<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ActivityRegistrationTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 15; $i++) {
            DB::table('activity_registration')->insert([
                'activity_id' => $faker->numberBetween(1, 8),
                'community_id' => $faker->numberBetween(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}