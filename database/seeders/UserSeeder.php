<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (avoid duplicates)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create normal user (avoid duplicates)
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'username' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Create additional users only if we don't have enough
        $existingUsersCount = User::count();
        if ($existingUsersCount < 10) {
            $usersToCreate = 10 - $existingUsersCount;
            User::factory()->count($usersToCreate)->create();
        }
    }
}
