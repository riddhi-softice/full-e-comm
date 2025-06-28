<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['id' => 1, 'name' => 'Rolex', 'logo' => 'brands/rolex.png'],
            ['id' => 2, 'name' => 'Casio', 'logo' => 'brands/casio.png'],
            ['id' => 3, 'name' => 'Fossil', 'logo' => 'brands/fossil.png'],
            ['id' => 4, 'name' => 'Omega', 'logo' => 'brands/omega.png'],
            ['id' => 5, 'name' => 'Timex', 'logo' => 'brands/timex.png'],
        ];
        foreach ($brands as $brand) {
            Brand::create($brand);
        }


        $categories = [
            ['id' => 1, 'name' => 'Luxury', 'slug' => 'luxury'],
            ['id' => 2, 'name' => 'Sports', 'slug' => 'sports'],
            ['id' => 3, 'name' => 'Smartwatches', 'slug' => 'smartwatches'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }


        $products = [
            [
                'name' => 'Rolex Submariner',
                'slug' => 'rolex-submariner',
                'description' => 'Iconic dive watch with unmatched durability and style.',
                'price' => 750000,
                'sale_price' => 699000,
                'stock' => 15,
                'warranty_years' => 5,
                'brand_id' => 1,
                'category_id' => 1
            ],
            [
                'name' => 'Casio G-Shock GA-2100',
                'slug' => 'casio-gshock-ga2100',
                'description' => 'Rugged watch with carbon core guard and analog-digital display.',
                'price' => 12000,
                'sale_price' => 9999,
                'stock' => 40,
                'warranty_years' => 2,
                'brand_id' => 2,
                'category_id' => 2
            ],
            [
                'name' => 'Fossil Gen 6 Smartwatch',
                'slug' => 'fossil-gen-6-smartwatch',
                'description' => 'Smartwatch with Wear OS and SpO2 tracking.',
                'price' => 24999,
                'sale_price' => 22999,
                'stock' => 25,
                'warranty_years' => 2,
                'brand_id' => 3,
                'category_id' => 3
            ],
            [
                'name' => 'Omega Speedmaster Moonwatch',
                'slug' => 'omega-speedmaster-moonwatch',
                'description' => 'Legendary chronograph worn on the moon.',
                'price' => 560000,
                'sale_price' => null,
                'stock' => 10,
                'warranty_years' => 5,
                'brand_id' => 4,
                'category_id' => 1
            ],
            [
                'name' => 'Timex Expedition Scout',
                'slug' => 'timex-expedition-scout',
                'description' => 'Durable outdoor watch with Indiglo backlight.',
                'price' => 4500,
                'sale_price' => 3999,
                'stock' => 60,
                'warranty_years' => 1,
                'brand_id' => 5,
                'category_id' => 2
            ]
        ];
        foreach ($products as $product) {
            Product::create($product);
        }
    }


}
