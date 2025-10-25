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
<<<<<<< HEAD
        // Only create products if we don't have enough
        $existingCount = Product::count();
        if ($existingCount < 20) {
            $toCreate = 20 - $existingCount;
            Product::factory()->count($toCreate)->create();
        }
=======
        Product::factory()->count(20)->create();
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
