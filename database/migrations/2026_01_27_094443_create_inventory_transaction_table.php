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
        Schema::create('inventory_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_type_id')->constrained('inventory_type')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branch')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transaction');
    }
};
