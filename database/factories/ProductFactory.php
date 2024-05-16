<?php

namespace Database\Factories;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        $imageUrls = [];
        for ($i = 0; $i < 3; $i++) {
            $imageUrls[] = $this->faker->imageUrl(); 
        }

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'brand' => $this->faker->word, // Adding brand field
            'quantity' => $this->faker->numberBetween(1, 10000),
            'is_featured' => $this->faker->boolean(40),
            'image' => $imageUrls, // Generates a placeholder image URL
        ];
    } 
}
