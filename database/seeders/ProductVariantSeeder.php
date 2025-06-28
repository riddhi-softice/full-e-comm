<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;


class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $variants =  [
                 [
                    'product_id' => 2,
                    'color' => 'Red',
                    'strap_material' => 'Resin',
                    'size_diameter' => 44.0,
                    'price' => 9999,
                    'stock' => 10,
                ],
                [
                    'product_id' => 3,
                    'color' => 'Silver',
                    'strap_material' => 'Leather',
                    'size_diameter' => 42.0,
                    'price' => 22999,
                    'stock' => 7,
                ],
                [
                    'product_id' => 4,
                    'color' => 'White',
                    'strap_material' => 'Stainless Steel',
                    'size_diameter' => 42.5,
                    'price' => 560000,
                    'stock' => 4,
                ],
                [
                    'product_id' => 5,
                    'color' => 'Green',
                    'strap_material' => 'Nylon',
                    'size_diameter' => 43.0,
                    'price' => 3999,
                    'stock' => 15,
                ],
            ];


        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}
