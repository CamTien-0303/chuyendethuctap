<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create customers if we don't have enough
        $existingCount = Customer::count();
        if ($existingCount < 15) {
            $toCreate = 15 - $existingCount;
            Customer::factory()->count($toCreate)->create();
        }
    }
}
