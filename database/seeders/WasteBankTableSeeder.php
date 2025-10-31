<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WasteBankTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 5; $i++) {
            DB::table('waste_bank')->insert([
                'waste_bank_submission_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}