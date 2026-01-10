<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create ADMIN Account
        User::create([
            'name' => 'Nazran',
            'email' => 'nazranlokman04@gmail.com',
            'password' => Hash::make('password'), // Password is 'password'
            'role' => 'admin',
        ]);

        // 2. Create STUDENT Account
        User::create([
            'name' => 'Wici',
            'email' => 'wici@gmail.com',
            'password' => Hash::make('password'), // Password is 'password'
            'role' => 'user', // or 'user', depending on your setup
        ]);
    }
}