<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Only create brands if we don't have enough
        $existingCount = Brand::count();
        if ($existingCount < 12) {
            $toCreate = 12 - $existingCount;
            Brand::factory()->count($toCreate)->create();
        }
=======
        Brand::factory()->count(12)->create();
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
