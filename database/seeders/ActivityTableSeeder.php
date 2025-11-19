<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ActivityTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $activities = [
            'Gerakan Bersih-Bersih Sungai',
            'Workshop Daur Ulang Plastik',
            'Penanaman Pohon Serentak',
            'Edukasi Pemilahan Sampah',
            'Kompetisi Kreasi Daur Ulang',
            'Aksi pungut Sampah Pantai',
            'Seminar Zero Waste Lifestyle',
            'Pelatihan Kompos Rumahan'
        ];

        $activitiesPhoto = [
            'activity.png',
            'activity2.png',
            'activity3.png',
            'activity4.png',
            'activity5.png',
        ];

        foreach ($activities as $activity) {
            DB::table('activity')->insert([
                'title' => $activity,
                'description' => $faker->paragraph(3),
                'photo' => 'activity/' . $activitiesPhoto[array_rand($activitiesPhoto)],
                'quota' => $faker->numberBetween(20, 100),
                'location' =>'Batam',
                'current_quota' => 0,
                'registration_start_date' => $faker->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
                'registration_due_date' => $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
                'start_date' => $faker->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
                'due_date' => $faker->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}