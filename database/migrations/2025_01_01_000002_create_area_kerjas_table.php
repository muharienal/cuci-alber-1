<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('area_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained('zonas')->cascadeOnDelete();
            $table->string('nama');
            $table->timestamps();

            $table->unique(['zona_id', 'nama']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_kerjas');
    }
};
