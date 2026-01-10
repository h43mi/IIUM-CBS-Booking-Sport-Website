<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // THIS IS THE KEY FIX: Add 'group_id' and 'court_number' here
    protected $fillable = [
        'user_id',
        'court_id',
        'group_id',      // <--- Crucial for grouping bookings
        'court_number',  // <--- Crucial for "Court A"
        'date',
        'start_time',
        'end_time',
        'status',
        'payment_proof', // If you add file upload later
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}