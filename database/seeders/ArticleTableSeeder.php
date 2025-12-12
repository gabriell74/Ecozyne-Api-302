<?php
namespace Database\Seeders;

use Illuminate\Http\File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $articles = [
            'Apa itu eco enzyme?',
            'What is eco enzyme?',
            'Manfaat eco enzyme bagi kehidupan sehari-hari',
        ];

        for ($i = 1; $i <= 3; $i++) {
            $sourcePath = public_path("images/foto/article{$i}.png");
            $storedPath = Storage::disk('public')->putFile('article', new File($sourcePath));
            $article = $articles[$i - 1];

            DB::table('article')->insert([
                'title' => $article,
                'description' => $faker->text(500),
                'photo' => $storedPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };
    }
}