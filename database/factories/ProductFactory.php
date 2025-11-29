<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => null,
            'sku' => strtoupper(Str::random(8)),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(10000, 500000),
            'stock' => fake()->numberBetween(1, 100),
            'active' => true,
        ];
    }
}
