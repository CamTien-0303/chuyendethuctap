<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
    public function definition(): array
    {
        $flowerProducts = [
            'Red Rose Bouquet',
            'Sunflower Surprise',
            'Tulip Symphony',
            'Orchid Elegance',
            'Lily Majesty',
            'Daisy Delight',
            'Carnation Charm',
            'Chrysanthemum Magic',
            'Mixed Spring Flowers',
            'Wedding White Collection',
            'Birthday Bash Bouquet',
            'Valentine\'s Special',
            'Mother\'s Day Arrangement',
            'Anniversary Bouquet',
            'Sympathy Arrangement',
            'Get Well Soon Flowers',
            'New Baby Celebration',
            'Congratulations Bouquet',
            'Thank You Blooms',
            'Graduation Glory'
        ];

        return [
            'name' => fake()->unique()->randomElement($flowerProducts),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'price' => fake()->randomFloat(2, 20, 200),
            'description' => fake()->paragraphs(3, true),
            'image' => 'products/product-' . fake()->numberBetween(1, 20) . '.jpg',
            'stock' => fake()->numberBetween(5, 100),
            'is_active' => fake()->boolean(90),
            'is_featured' => fake()->boolean(20),
        ];
    }
}
