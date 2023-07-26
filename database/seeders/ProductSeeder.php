<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 20; $i++) {
            Product::create([
                'category_id' => rand(1, 3),
                'subcategory_id' => rand(1, 4),
                'nama_barang' => 'Lorem Ipsum Dolor Sit Amet',
                'harga' => rand(1000, 100000),
                'diskon' => 0,
                'bahan' => 'Lorem Ipsum Dolor',
                'tags' => 'Lorem,Ipsum,Dolor,Sit,Amet',
                'sku' => Str::random(8),
                'ukuran' => 'S,M,L,XL',
                'warna' => 'Hitam,Biru,Kuning,Putih,Hijau',
                'image' => 'shop_image_' . $i . '.jpg',
                'description' => 'Lorem Ipsum Dolor Sit Amet'
            ]);
        }
    }
}