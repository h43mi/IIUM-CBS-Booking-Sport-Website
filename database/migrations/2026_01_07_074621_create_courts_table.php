<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('courts', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type');
        $table->decimal('price', 8, 2);
        $table->string('status')->default('Available');
        
        // --- ADD THIS LINE ---
        $table->string('image')->nullable(); 
        // ---------------------

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};