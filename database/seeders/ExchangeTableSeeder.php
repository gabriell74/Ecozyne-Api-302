<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExchangeTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('exchange')->insert([
                'community_id' => $faker->numberBetween(1, 20),
                'exchange_status' => $faker->randomElement(['rejected', 'pending', 'approved']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}