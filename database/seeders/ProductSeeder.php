<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the number of new products you want to create
        $numberOfProductsToCreate = 10;

        // Loop to create new products
        for ($i = 0; $i < $numberOfProductsToCreate; $i++) {
            $newProduct = Product::factory()->make();

            // Check if a product with the same name and description already exists
            $existingProduct = Product::where('name', $newProduct->name)->first();

            // If no existing product found, create a new one
            if (!$existingProduct) {
                Product::create($newProduct->toArray());
            }
        }
    }
}
