<?php
namespace Database\Seeders;

use Illuminate\Http\File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RewardTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $rewards = [
            ['Beras 5 Kg', 1000],
            ['Gula 1 Kg', 300],
            ['Minyak 1 Liter', 200],
            ['Jus Coy', 100],
        ];

        for ($i = 1; $i <= 4; $i++) {
            $sourcePath = public_path("images/foto/gift{$i}.png");
            $storedPath = Storage::disk('public')->putFile('reward', new File($sourcePath));
            $reward = $rewards[$i - 1];

            DB::table('reward')->insert([
                'reward_name' => $reward[0],
                'photo' => $storedPath,
                'stock' => $faker->numberBetween(5, 50),
                'unit_point' => $reward[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };

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