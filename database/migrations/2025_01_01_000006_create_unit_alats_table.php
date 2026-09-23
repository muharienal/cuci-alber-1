<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_alats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_kerja_id')->constrained('unit_kerjas')->cascadeOnDelete();
            $table->foreignId('jenis_alat_id')->constrained('jenis_alats')->cascadeOnDelete();
            $table->string('no_lambung');
            $table->string('kepemilikan')->nullable(); // PCS, WKK, YAYASAN, BAA, dst
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['unit_kerja_id', 'jenis_alat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_alats');
    }
};
