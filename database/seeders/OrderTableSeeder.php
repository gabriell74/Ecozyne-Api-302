<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 15; $i++) {
            DB::table('order')->insert([
                'community_id' => $faker->numberBetween(1, 20),
                'waste_bank_id' => $faker->numberBetween(1, 5),
                'status_order' => $faker->randomElement(['pending', 'processed', 'delivered', 'cancelled']),
                'status_payment' => $faker->randomElement(['pending', 'paid', 'failed']),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}