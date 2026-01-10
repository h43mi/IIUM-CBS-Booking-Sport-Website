<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    // ADD THIS LIST to allow saving these fields
    protected $fillable = [
        'name',
        'type',
        'price',
        'status',
        'image', // Include this if you plan to upload images later
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}