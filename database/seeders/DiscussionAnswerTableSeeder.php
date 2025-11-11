<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DiscussionAnswerTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 25; $i++) {
            DB::table('discussion_answer')->insert([
                'user_id' => $faker->numberBetween(1, 25),
                'question_id' => $faker->numberBetween(1, 15),
                'answer' => $faker->paragraph(3),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}