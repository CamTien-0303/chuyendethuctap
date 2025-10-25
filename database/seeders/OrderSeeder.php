<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create orders if we don't have enough
        $existingCount = Order::count();
        if ($existingCount < 10) {
            $toCreate = 10 - $existingCount;
            Order::factory()->count($toCreate)->create();
        }
    }
}
