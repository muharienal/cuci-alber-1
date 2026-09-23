<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_operators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_alat_id')->constrained('unit_alats')->cascadeOnDelete();
            $table->foreignId('operator_id')->constrained('operators')->cascadeOnDelete();
            $table->enum('grup', ['A', 'B', 'C', 'D']);
            $table->timestamps();

            $table->unique(['unit_alat_id', 'grup']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_operators');
    }
};
