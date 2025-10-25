<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create products if we don't have enough
        $existingCount = Product::count();
        if ($existingCount < 20) {
            $toCreate = 20 - $existingCount;
            Product::factory()->count($toCreate)->create();
        }
    }
}
