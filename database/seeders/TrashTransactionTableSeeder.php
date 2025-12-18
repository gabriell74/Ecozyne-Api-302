<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TrashTransactionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 25; $i++) {
            DB::table('trash_transaction')->insert([
                'waste_bank_id' => $faker->numberBetween(1, 5),
                'user_id' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['rejected', 'pending', 'approved']),
                'rejectionReason' => $faker->optional()->sentence(),
                'point_earned' => $faker->numberBetween(10, 100),
                'trash_weight' => $faker->numberBetween(1, 20),
                'created_at' => $faker->dateTimeBetween('-2 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}