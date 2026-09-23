<?php

namespace Database\Seeders;

use App\Models\Pengawas;
use Illuminate\Database\Seeder;

class PengawasSeeder extends Seeder
{
    public function run(): void
    {
        $rows = require __DIR__ . '/pengawas_data.php';

        foreach ($rows as $row) {
            Pengawas::firstOrCreate([
                'nama' => $row['nama'],
                'wilayah' => $row['wilayah'],
            ]);
        }

        $this->command->info('Selesai import ' . count($rows) . ' data pengawas.');
    }
}
