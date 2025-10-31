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
        
        for ($i = 1; $i <= 20; $i++) {
            DB::table('product_transaction')->insert([
                'order_id' => $faker->numberBetween(1, 15),
                'product_id' => $faker->numberBetween(1, 5),
                'price' => $faker->numberBetween(15000, 100000),
                'amount' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}