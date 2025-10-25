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
        // Only create categories if we don't have enough
        $existingCount = Category::count();
        if ($existingCount < 12) {
            $toCreate = 12 - $existingCount;
            Category::factory()->count($toCreate)->create();
        }
    }
}
