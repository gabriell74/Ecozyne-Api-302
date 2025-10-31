<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RewardTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $rewards = [
            ['Voucher Belanja Rp 50.000', 500],
            ['Tumbler Ecozyne', 300],
            ['Totebag Kain', 200],
            ['Bibit Tanaman', 100],
            ['Paket Alat Daur Ulang', 800],
            ['E-book Zero Waste', 150],
            ['Merchandise Exclusive', 400]
        ];

        foreach ($rewards as $reward) {
            DB::table('reward')->insert([
                'reward_name' => $reward[0],
                'photo' => 'reward_' . \Illuminate\Support\Str::slug($reward[0]) . '.jpg',
                'stock' => $faker->numberBetween(5, 50),
                'unit_point' => $reward[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}