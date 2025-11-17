<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ExchangeTransactionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 15; $i++) {
            DB::table('exchange_transaction')->insert([
                'exchange_id' => $faker->numberBetween(1, 10),
                'reward_id' => $faker->numberBetween(1, 7),
                'amount' => $faker->numberBetween(1, 3),
                'total_unit_point' => $faker->numberBetween(100, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}