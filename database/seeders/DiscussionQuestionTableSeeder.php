<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DiscussionQuestionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 15; $i++) {
            DB::table('discussion_question')->insert([
                'user_id' => $faker->numberBetween(7, 26), // Community users
                'question' => $faker->paragraph(2) . '?',
                'total_like' => $faker->numberBetween(0, 50),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}