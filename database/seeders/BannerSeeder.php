<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Only create banners if we don't have enough
        $existingCount = Banner::count();
        if ($existingCount < 5) {
            $toCreate = 5 - $existingCount;
            Banner::factory()->count($toCreate)->create();
        }
=======
        Banner::factory()->count(5)->create();
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
