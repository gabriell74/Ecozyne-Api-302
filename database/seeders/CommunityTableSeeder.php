<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommunityTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Community users start from ID 7 (after 1 admin + 5 waste banks)
        for ($i = 7; $i <= 26; $i++) {
            DB::table('community')->insert([
                'user_id' => $i,
                'address_id' => $faker->numberBetween(1, 25),
                'photo' => 'community_' . $i . '.jpg',
                'phone_number' => $faker->phoneNumber(),
                'name' => $faker->company() . ' Community',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}