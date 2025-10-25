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
        // Only create brands if we don't have enough
        $existingCount = Brand::count();
        if ($existingCount < 12) {
            $toCreate = 12 - $existingCount;
            Brand::factory()->count($toCreate)->create();
        }
    }
}
