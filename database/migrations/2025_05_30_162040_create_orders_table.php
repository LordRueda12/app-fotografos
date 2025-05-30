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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('photographer_id')->constrained('users', 'id')->onDelete('cascade');
            $table->json('details');
            $table->integer('total');
            $table->enum('status', ['pendiente', 'confirmada', 'completada', 'cancelada'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
