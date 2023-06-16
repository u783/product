<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'image' => $this->faker->imageUrl(),
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'manufacturer' => $this->faker->company,
            'description' => $this->faker->paragraph,
        ];
    }
}

