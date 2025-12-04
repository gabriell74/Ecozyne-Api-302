<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WasteBankSubmissionTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 10; $i++) {
            DB::table('waste_bank_submission')->insert([
                'community_id' => $faker->numberBetween(1, 20),
                'waste_bank_name' => $faker->company() . ' Waste Bank',
                'waste_bank_location' => $faker->address(),
                'photo' => 'poto',
                'latitude' => $faker->latitude(-6.8, -6.9),
                'longitude' => $faker->longitude(107.5, 107.7),
                'file_document' => 'document_' . $i . '.pdf',
                'notes' => $faker->sentence(),
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}