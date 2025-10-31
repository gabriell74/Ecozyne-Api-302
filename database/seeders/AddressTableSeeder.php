<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AddressTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 25; $i++) {
            DB::table('address')->insert([
                'kelurahan_id' => $faker->numberBetween(1, 30),
                'address' => $faker->address(),
                'postal_code' => $faker->postcode(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}