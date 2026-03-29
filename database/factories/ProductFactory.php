<?php

namespace Database\Factories;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'type' => $this->faker->randomElement(ProductType::cases())->value,
            'category_id' => null,
            'description' => $this->faker->paragraph(),
            'body' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'cover_path' => null,
            'is_published' => true,
            'in_stock' => true,
            'stock_qty' => $this->faker->optional()->numberBetween(1, 100),
            'weight_kg' => null,
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    public function digital(): static
    {
        return $this->state(['type' => ProductType::Digital->value, 'weight_kg' => null, 'stock_qty' => null]);
    }

    public function physical(): static
    {
        return $this->state([
            'type' => ProductType::Physical->value,
            'weight_kg' => $this->faker->randomFloat(3, 0.1, 5.0),
            'stock_qty' => $this->faker->numberBetween(1, 50),
        ]);
    }
}
