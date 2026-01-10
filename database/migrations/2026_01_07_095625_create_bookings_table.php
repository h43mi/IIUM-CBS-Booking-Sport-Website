<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Link to the Student (User)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Link to the Court being booked
            $table->foreignId('court_id')->constrained()->onDelete('cascade');
            
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status')->default('Upcoming'); // Upcoming, Completed, Cancelled
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
