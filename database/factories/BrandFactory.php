<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flowerBrands = [
            'Bloom & Wild',
            'FTD Flowers',
            '1-800-Flowers',
            'ProFlowers',
            'The Bouqs Co.',
            'Teleflora',
            'BloomNation',
            'FromYouFlowers',
            'UrbanStems',
            'Farmgirl Flowers',
            'Venus ET Fleur',
            'Floraqueen'
        ];

        return [
            'name' => fake()->unique()->randomElement($flowerBrands),
            'image' => 'brands/brand-' . fake()->numberBetween(1, 10) . '.jpg',
            'description' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
