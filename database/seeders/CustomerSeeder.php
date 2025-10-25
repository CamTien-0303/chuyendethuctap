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
<<<<<<< HEAD
        // Only create customers if we don't have enough
        $existingCount = Customer::count();
        if ($existingCount < 15) {
            $toCreate = 15 - $existingCount;
            Customer::factory()->count($toCreate)->create();
        }
=======
        Customer::factory()->count(15)->create();
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
