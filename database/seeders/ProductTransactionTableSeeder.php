<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTransactionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $rewards = [
            'Beras 5 Kg',
            'Gula 1 Kg',
            'Minyak 1 Liter',
            'Jus Coy'
        ];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('product_transaction')->insert([
                'order_id' => $faker->numberBetween(1, 15),
                'product_id' => $faker->numberBetween(1, 4),
                'product_name' => $rewards[array_rand($rewards)],
                'product_price' => $faker->numberBetween(1, 5),
                'total_price' => $faker->numberBetween(15000, 100000),
                'amount' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}