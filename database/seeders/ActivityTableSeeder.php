<?php
namespace Database\Seeders;

use Illuminate\Http\File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActivityTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $activities = [
            'Gerakan Bersih-Bersih Sungai',
            'Aksi pungut Sampah Pantai',
            'Pelatihan Kompos Rumahan',
            'Workshop Daur Ulang Plastik',
            'Penanaman Pohon Serentak',
        ];

        for ($i = 1; $i <= 5; $i++) {
            $sourcePath = public_path("images/foto/activity{$i}.png");
            $storedPath = Storage::disk('public')->putFile('activity', new File($sourcePath));
            $activityTitle = $activities[$i - 1];

            DB::table('activity')->insert([
                'title' => $activityTitle,
                'description' => $faker->paragraph(3),
                'photo' => $storedPath,
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

        $activityIds = DB::table('activity')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $activityId = $faker->randomElement($activityIds);

            DB::table('activity_registration')->insert([
                'activity_id' => $activityId,
                'community_id' => $faker->numberBetween(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('activity')->where('id', $activityId)->increment('current_quota', 1);
        }
    }
}