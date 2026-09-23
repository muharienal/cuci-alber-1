<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_kerja_id')->constrained('area_kerjas')->cascadeOnDelete();
            $table->string('nama');
            $table->unsignedInteger('kebutuhan_alat_inti')->nullable();
            $table->timestamps();

            $table->unique(['area_kerja_id', 'nama']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_kerjas');
    }
};
