<?php

namespace Database\Seeders;

use App\Models\AreaKerja;
use App\Models\JenisAlat;
use App\Models\Operator;
use App\Models\UnitAlat;
use App\Models\UnitKerja;
use App\Models\UnitOperator;
use App\Models\Zona;
use Illuminate\Database\Seeder;

/**
 * Seeder ini mengisi database dengan data ASLI yang diambil dari file Excel
 * "Ploting Terbaru Area Alat Berat dan Operator Alat Berat" yang diupload user.
 * Data mentah disimpan di ploting_data.php (86 unit: 59 Forklift + 27 Wheel Loader).
 */
class PlotingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = require __DIR__ . '/ploting_data.php';

        foreach ($rows as $row) {
            $zona = Zona::firstOrCreate(['nama' => $row['zona']]);

            $areaKerja = AreaKerja::firstOrCreate([
                'zona_id' => $zona->id,
                'nama' => $row['area_kerja'],
            ]);

            $unitKerja = UnitKerja::firstOrCreate(
                [
                    'area_kerja_id' => $areaKerja->id,
                    'nama' => $row['unit_kerja'],
                ],
                [
                    'kebutuhan_alat_inti' => $row['kebutuhan_alat_inti'],
                ]
            );

            $jenisAlat = JenisAlat::firstOrCreate(['nama' => $row['jenis_alat']]);

            $unitAlat = UnitAlat::firstOrCreate(
                [
                    'unit_kerja_id' => $unitKerja->id,
                    'jenis_alat_id' => $jenisAlat->id,
                    'no_lambung' => $row['no_lambung'],
                ],
                [
                    'kepemilikan' => $row['kepemilikan'],
                ]
            );

            foreach ($row['operators'] as $grup => $namaOperator) {
                if (empty($namaOperator)) {
                    continue;
                }

                $operator = Operator::firstOrCreate(['nama' => $namaOperator]);

                UnitOperator::firstOrCreate([
                    'unit_alat_id' => $unitAlat->id,
                    'grup' => $grup,
                ], [
                    'operator_id' => $operator->id,
                ]);
            }
        }

        $this->command->info('Selesai import ' . count($rows) . ' unit alat berat beserta operatornya.');
    }
}
