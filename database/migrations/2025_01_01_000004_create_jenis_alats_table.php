<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // contoh: Forklift, Wheel Loader
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_alats');
    }
};
