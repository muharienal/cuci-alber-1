<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();

            // unit yang dicuci (hanya salah satu: Forklift ATAU Wheel Loader)
            $table->foreignId('unit_alat_id')->constrained('unit_alats')->cascadeOnDelete();

            $table->foreignId('pengawas_id')->nullable()->constrained('pengawas')->nullOnDelete();
            $table->enum('shift', ['1', '2', '3']);

            // operator yang mencuci - bisa lebih dari satu sumber, sesuai form asli
            $table->foreignId('operator_nd_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('operator_grup_a_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('operator_grup_b_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('operator_grup_c_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('operator_grup_d_id')->nullable()->constrained('operators')->nullOnDelete();

            // bukti foto disimpan di tabel terpisah (submission_photos) - bisa lebih dari 1 foto

            $table->timestamps();

            // snapshot text supaya laporan lama tetap valid walau master data berubah/dihapus
            $table->string('zona_snapshot')->nullable();
            $table->string('area_kerja_snapshot')->nullable();
            $table->string('unit_kerja_snapshot')->nullable();
            $table->string('jenis_alat_snapshot')->nullable();
            $table->string('no_lambung_snapshot')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
