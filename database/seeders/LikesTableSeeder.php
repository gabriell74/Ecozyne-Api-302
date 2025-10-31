<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LikesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $likes = [];
        $existingLikes = [];
        
        for ($i = 1; $i <= 30; $i++) {
            $user_id = $faker->numberBetween(7, 26); // Community users
            $question_id = $faker->numberBetween(1, 15);
            
            // Cek kombinasi user_id + question_id sudah ada
            $key = $user_id . '-' . $question_id;
            
            if (!in_array($key, $existingLikes)) {
                $likes[] = [
                    'user_id' => $user_id,
                    'question_id' => $question_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $existingLikes[] = $key;
            }
        }
        
        DB::table('likes')->insert($likes);
    }
}