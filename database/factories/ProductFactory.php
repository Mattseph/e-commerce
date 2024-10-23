<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

    {
        $category_id = Category::pluck('id')->toArray();
        $brand_id = Brand::pluck('id')->toArray();
        $user_id = User::pluck('id')->toArray();
        return [
            'category_id' => fake()->randomElement($category_id),
            'brand_id' => fake()->randomElement($brand_id),
            'title' => fake()->unique()->realText(),
            'slug' => fake()->realText(),
            'quantity' => fake()->randomNumber(4),
            'description' => fake()->realText(),
            'published' => fake()->boolean(),
            'inStock' => fake()->boolean(),
            'price' => fake()->randomFloat(2),
            'created_by' => fake()->randomElement($user_id),
            'updated_by' => fake()->randomElement($user_id),
        ];
    }
}
