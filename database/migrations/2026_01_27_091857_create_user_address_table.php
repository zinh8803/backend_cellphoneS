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
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('detail')->nullable();
            $table->string('receiver_name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_default')->nullable();
            $table->foreignId('city_id')->constrained('city')->onDelete('cascade');
            $table->foreignId('ward_id')->constrained('ward')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_address');
    }
};
