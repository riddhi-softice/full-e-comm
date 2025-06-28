<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RelatedProduct;

class RelatedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $related = [
            [
                'product_id' => 1, // Rolex Submariner
                'related_product_id' => 4, // Omega Speedmaster
            ],
            [
                'product_id' => 1,
                'related_product_id' => 2, // Casio G-Shock
            ],
            [
                'product_id' => 2, // Casio G-Shock
                'related_product_id' => 5, // Timex
            ],
            [
                'product_id' => 3, // Fossil Gen 6
                'related_product_id' => 5,
            ],
            [
                'product_id' => 4,
                'related_product_id' => 1,
            ],
            [
                'product_id' => 5,
                'related_product_id' => 2,
            ],
        ];

        foreach ($related as $row) {
            RelatedProduct::create($row);
        }
    }
}
