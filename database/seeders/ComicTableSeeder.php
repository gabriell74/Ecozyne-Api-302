<?php
namespace Database\Seeders;

use App\Models\Comic;
use Illuminate\Http\File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComicTableSeeder extends Seeder
{
    public function run()
    {
        $sourcePath = public_path('images/foto/comic_cover1.jpg');

        if (file_exists($sourcePath)) {
            $storedPath = Storage::disk('public')->putFile('comic', new File($sourcePath));
        }

        $comic = Comic::create([
            'comic_title' => 'Miko & Lobak',
            'cover_photo' => $storedPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 1; $i <= 2; $i++) {

            $sourcePath2 = public_path("images/comics/miko_dan_lobak/page{$i}.png");
            $storedPath2 = Storage::disk('public')->putFile('comic/comic_pages', new File($sourcePath2));

            DB::table('comic_photo')->insert([
                'comic_id' => $comic->id,
                'comic_page' => $i,
                'photo' => $storedPath2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}