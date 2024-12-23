<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=ProductImage>
 */
class ProductImageFactory extends Factory
{

    protected $model = ProductImage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product_id = Product::pluck('id')->toArray();
        return [
            'product_id' => fake()->randomElement($product_id),
            'image' => fake()->imageUrl(),
        ];
    }
}
