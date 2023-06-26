<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecantikan = Category::create(['name' => 'Kecantikan', 'total' => 37500]);
        $sabun = Category::create(['name' => 'Sabun', 'total' => 15000]);
        $minuman = Category::create(['name' => 'Minuman', 'total' => 8000]);
        $makanan = Category::create(['name' => 'Makanan', 'total' => 20000]);

        Products::insert([[
            'name' => 'Handbody Marina',
            'price' => 25000,
            'discount' => '10.00',
            'photo' => 'marina.jpg',
        ],[
            'name' => 'Biore',
            'price' => 15000,
            'discount' => '0',
            'photo' => 'biore.jpg',
        ]]);

        Products::create([
            'name' => 'Frisian Flag Coklat',
            'price' => 8000,
            'discount' => '0',
            'photo' => 'frisian.png',
        ]);

        Products::create([
            'name' => 'Sari Roti Coklat',
            'price' => 20000,
            'discount' => '0',
            'photo' => 'sariroti.jpg',
        ]);

        $kecantikan->productCat()->createMany([['product_id' => 1], ['product_id' => 2]]);
        $sabun->productCat()->create(['product_id' => 2]);
        $minuman->productCat()->create(['product_id' => 3]);
        $makanan->productCat()->create(['product_id' => 4]);
    }
}
