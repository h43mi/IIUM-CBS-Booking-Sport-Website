<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BADMINTON
        Court::create([
            'name' => 'Male Sport Complex',
            'type' => 'Badminton',
            'price' => 5.00,
            'status' => 'Available',
            'image' => 'badminton.jpeg', // <--- Added Image
        ]);

        Court::create([
            'name' => 'Female Sport Complex',
            'type' => 'Badminton',
            'price' => 5.00,
            'status' => 'Available',
            'image' => 'badminton.jpeg',
        ]);

        // 2. FUTSAL
        Court::create([
            'name' => 'Outdoor Futsal Arena A',
            'type' => 'Futsal',
            'price' => 15.00,
            'status' => 'Available',
            'image' => 'court2.jpg', // <--- Added Image
        ]);
        
        Court::create([
            'name' => 'Outdoor Futsal Arena B',
            'type' => 'Futsal',
            'price' => 15.00,
            'status' => 'Available',
            'image' => 'court2.jpg',
        ]);

        // 3. TENNIS
        Court::create([
            'name' => 'Varsity Tennis Court',
            'type' => 'Tennis',
            'price' => 10.00,
            'status' => 'Available',
            'image' => 'court3.jpg', // <--- Added Image
        ]);

        // 4. VOLLEYBALL
        Court::create([
            'name' => 'Volleyball Court 1',
            'type' => 'Volleyball',
            'price' => 8.00,
            'status' => 'Available',
            'image' => 'court1.webp', // <--- Added Image
        ]);
    }
}