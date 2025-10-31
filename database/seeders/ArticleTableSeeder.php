<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ArticleTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $articles = [
            'Cara Memilah Sampah yang Benar untuk Pemula',
            'Manfaat Daur Ulang Plastik bagi Lingkungan',
            '5 Langkah Mudah Mengurangi Sampah Rumah Tangga',
            'Inovasi Baru dalam Pengolahan Sampah Organik',
            'Mengenal Jenis-Jenis Plastik dan Cara Daur Ulangnya',
            'Tips Membuat Kompos dari Sampah Dapur',
            'Dampak Sampah Plastik terhadap Ekosistem Laut',
            'Gerakan Zero Waste: Mulai dari Hal Kecil'
        ];

        foreach ($articles as $article) {
            DB::table('article')->insert([
                'title' => $article,
                'description' => $faker->text(500),
                'photo' => 'article_' . \Illuminate\Support\Str::slug($article) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}