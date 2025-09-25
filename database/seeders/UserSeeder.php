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
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create normal user
        User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create additional users
        User::factory()->count(8)->create();
    }
}
