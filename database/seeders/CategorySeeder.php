<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Only create categories if we don't have enough
        $existingCount = Category::count();
        if ($existingCount < 12) {
            $toCreate = 12 - $existingCount;
            Category::factory()->count($toCreate)->create();
        }
=======
        Category::factory()->count(12)->create();
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
