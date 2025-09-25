<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'image' => 'banners/banner-' . fake()->numberBetween(1, 5) . '.jpg',
            'link' => fake()->randomElement(['https://www.lazada.vn/', 'https://shopee.vn/', 'https://www.tiki.vn/']),
            'is_active' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
