<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $products = [
            ['Tas dari Banner Bekas', 'Tas cantik dari bahan banner daur ulang', 75000],
            ['Pot Tanaman dari Botol Plastik', 'Pot tanaman unik dari botol plastik daur ulang', 25000],
            ['Kerajinan dari Sedotan', 'Berbagai kerajinan tangan dari sedotan bekas', 15000],
            ['Dompet dari Kemasan Kopi', 'Dompet stylish dari kemasan kopi daur ulang', 50000],
            ['Placemat dari Koran', 'Placemat meja dari koran bekas daur ulang', 30000],
        ];

        foreach ($products as $product) {
            DB::table('product')->insert([
                'waste_bank_id' => $faker->numberBetween(1, 5),
                'product_name' => $product[0],
                'description' => $product[1],
                'price' => $product[2],
                'stock' => $faker->numberBetween(5, 50),
                'photo' => 'product_' . \Illuminate\Support\Str::slug($product[0]) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}