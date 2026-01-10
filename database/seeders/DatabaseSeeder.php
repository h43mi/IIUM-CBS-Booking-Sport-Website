<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run User Seeder (Restores Admin/Student)
        $this->call(UserSeeder::class);

        // Run Court Seeder (Restores Courts with correct Sports)
        $this->call(CourtSeeder::class);
    }
}