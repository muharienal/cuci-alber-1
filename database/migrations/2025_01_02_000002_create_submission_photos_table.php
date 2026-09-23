<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->string('path');
            $table->timestamps();
        });

        // Untuk database yang sudah pernah dibuat sebelum fitur multi-foto ada:
        // pindahkan isi kolom lama foto_tampak_samping (kalau ada) ke tabel baru,
        // baru kemudian kolom lamanya dihapus.
        if (Schema::hasColumn('submissions', 'foto_tampak_samping')) {
            $rows = \Illuminate\Support\Facades\DB::table('submissions')
                ->whereNotNull('foto_tampak_samping')
                ->get(['id', 'foto_tampak_samping']);

            foreach ($rows as $row) {
                \Illuminate\Support\Facades\DB::table('submission_photos')->insert([
                    'submission_id' => $row->id,
                    'path' => $row->foto_tampak_samping,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Schema::table('submissions', function (Blueprint $table) {
                $table->dropColumn('foto_tampak_samping');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('submissions', 'foto_tampak_samping')) {
            Schema::table('submissions', function (Blueprint $table) {
                $table->string('foto_tampak_samping')->nullable();
            });
        }

        Schema::dropIfExists('submission_photos');
    }
};
