<?php
// database/seeders/UsersTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Admin user
        DB::table('users')->insert([
            'username' => 'admin_ecozyne',
            'email' => 'admin@ecozyne.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Waste bank users
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'username' => $faker->userName() . '_bank',
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'waste_bank',
                'remember_token' => \Illuminate\Support\Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Community users
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'username' => $faker->userName(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'community',
                'remember_token' => \Illuminate\Support\Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // User Khusus Yusril
        // Komunitas
        DB::table('users')->insert([
            'username' => 'Yusril',
            'email' => 'iniemail616@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('@Yusril123'),
            'role' => 'community',
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Bank Sampah
        DB::table('users')->insert([
            'username' => 'Yusril_bank',
            'email' => 'yusril@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('@Yusril123'),
            'role' => 'waste_bank',
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}