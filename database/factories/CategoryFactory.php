<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flowerCategories = [
            'Roses',
            'Lilies',
            'Tulips',
            'Orchids',
            'Sunflowers',
            'Daisies',
            'Carnations',
            'Chrysanthemums',
            'Gerberas',
            'Mixed Bouquets',
            'Wedding Flowers',
            'Birthday Arrangements'
        ];

        return [
            'name' => fake()->unique()->randomElement($flowerCategories),
            'image' => 'categories/category-' . fake()->numberBetween(1, 10) . '.jpg',
            'description' => fake()->paragraph(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 12),
        ];
    }
}
