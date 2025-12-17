<?php
namespace Database\Seeders;

use Illuminate\Http\File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $products = [
            ['Tas dari Banner Bekas', 'Tas cantik dari bahan banner daur ulang', 75000],
            ['Pot Tanaman dari Botol Plastik', 'Pot tanaman unik dari botol plastik daur ulang', 25000],
            ['Kerajinan dari Sedotan', 'Berbagai kerajinan tangan dari sedotan bekas', 15000],
            ['Placemat dari Koran', 'Placemat meja dari koran bekas daur ulang', 30000],
        ];

        for ($i = 1; $i <= 4; $i++) {
            $sourcePath = public_path("images/foto/product{$i}.jpg");
            $storedPath = Storage::disk('public')->putFile('products', new File($sourcePath));
            $product = $products[$i - 1];

            DB::table('product')->insert([
                'waste_bank_id' => $faker->numberBetween(1, 5),
                'product_name' => $product[0],
                'description' => $product[1],
                'price' => $product[2],
                'stock' => $faker->numberBetween(5, 50),
                'photo' => $storedPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };
    }
}