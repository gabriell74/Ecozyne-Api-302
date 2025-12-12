<?php
namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunityTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Community users start from ID 7 (after 1 admin + 5 waste banks)
        for ($i = 7; $i <= 26; $i++) {
            DB::table('community')->insert([
                'user_id' => $i,
                'address_id' => $faker->numberBetween(1, 25),
                'photo' => 'community_' . $i . '.jpg',
                'phone_number' => $faker->phoneNumber(),
                'name' => $faker->company() . ' Community',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Komunitas Khusus Yusril
        $user = User::where('email', 'iniemail616@gmail.com')->first();
        $user_id = $user->id;

        DB::table('community')->insert([
            'user_id' => $user_id,
            'address_id' => $faker->numberBetween(1, 25),
            'photo' => 'yusril.jpg',
            'phone_number' => '085805368534',
            'name' => 'MyCommunity',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}