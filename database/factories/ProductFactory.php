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
            'product_name' => $this->faker->word,
            'price' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(0, 100),
            'company_name' => $this->faker->company,
            'comment' => $this->faker->paragraph,
        ];
    }
}

