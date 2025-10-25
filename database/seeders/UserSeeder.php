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
<<<<<<< HEAD
        // Create admin user (avoid duplicates)
        User::firstOrCreate(
=======
        // Create admin user (updateOrCreate để tránh duplicate)
        User::updateOrCreate(
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

<<<<<<< HEAD
        // Create normal user (avoid duplicates)
        User::firstOrCreate(
=======
        // Create normal user (updateOrCreate để tránh duplicate)
        User::updateOrCreate(
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'username' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

<<<<<<< HEAD
        // Create additional users only if we don't have enough
        $existingUsersCount = User::count();
        if ($existingUsersCount < 10) {
            $usersToCreate = 10 - $existingUsersCount;
            User::factory()->count($usersToCreate)->create();
        }
    }
}
=======
        // Create additional users (chỉ tạo nếu chưa có đủ)
        if (User::count() < 10) {
            User::factory()->count(8)->create();
        }
    }
}
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
