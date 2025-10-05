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
        // Create admin user (updateOrCreate để tránh duplicate)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create normal user (updateOrCreate để tránh duplicate)
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'username' => 'user',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Create additional users (chỉ tạo nếu chưa có đủ)
        if (User::count() < 10) {
            User::factory()->count(8)->create();
        }
    }
}