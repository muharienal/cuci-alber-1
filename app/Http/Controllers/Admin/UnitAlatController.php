<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisAlat;
use App\Models\Operator;
use App\Models\UnitAlat;
use App\Models\UnitKerja;
use App\Models\UnitOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitAlatController extends Controller
{
    public function index(Request $request)
    {
        $query = UnitAlat::with(['unitKerja.areaKerja.zona', 'jenisAlat', 'unitOperators.operator']);

        if ($request->filled('unit_kerja_id')) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }
        if ($request->filled('jenis_alat_id')) {
            $query->where('jenis_alat_id', $request->jenis_alat_id);
        }
        if ($search = $request->get('q')) {
            $query->where('no_lambung', 'like', "%{$search}%");
        }

        $unitAlats = $query->orderBy('no_lambung')->paginate(20)->withQueryString();

        $unitKerjas = UnitKerja::with('areaKerja.zona')->orderBy('nama')->get();
        $jenisAlats = JenisAlat::orderBy('nama')->get();
        $operators = Operator::orderBy('nama')->get();

        return view('admin.unit_alats.index', compact('unitAlats', 'unitKerjas', 'jenisAlats', 'operators'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_kerja_id' => ['required', 'exists:unit_kerjas,id'],
            'jenis_alat_id' => ['required', 'exists:jenis_alats,id'],
            'no_lambung' => ['required', 'string', 'max:100'],
            'kepemilikan' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'operator_a' => ['nullable', 'exists:operators,id'],
            'operator_b' => ['nullable', 'exists:operators,id'],
            'operator_c' => ['nullable', 'exists:operators,id'],
            'operator_d' => ['nullable', 'exists:operators,id'],
        ]);

        DB::transaction(function () use ($data) {
            $unitAlat = UnitAlat::create([
                'unit_kerja_id' => $data['unit_kerja_id'],
                'jenis_alat_id' => $data['jenis_alat_id'],
                'no_lambung' => $data['no_lambung'],
                'kepemilikan' => $data['kepemilikan'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $this->syncOperators($unitAlat, $data);
        });

        return back()->with('success', 'Unit alat berhasil ditambahkan.');
    }

    public function update(Request $request, UnitAlat $unitAlat)
    {
        $data = $request->validate([
            'unit_kerja_id' => ['required', 'exists:unit_kerjas,id'],
            'jenis_alat_id' => ['required', 'exists:jenis_alats,id'],
            'no_lambung' => ['required', 'string', 'max:100'],
            'kepemilikan' => ['nullable', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'operator_a' => ['nullable', 'exists:operators,id'],
            'operator_b' => ['nullable', 'exists:operators,id'],
            'operator_c' => ['nullable', 'exists:operators,id'],
            'operator_d' => ['nullable', 'exists:operators,id'],
        ]);

        DB::transaction(function () use ($data, $unitAlat) {
            $unitAlat->update([
                'unit_kerja_id' => $data['unit_kerja_id'],
                'jenis_alat_id' => $data['jenis_alat_id'],
                'no_lambung' => $data['no_lambung'],
                'kepemilikan' => $data['kepemilikan'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $this->syncOperators($unitAlat, $data);
        });

        return back()->with('success', 'Unit alat berhasil diperbarui.');
    }

    public function destroy(UnitAlat $unitAlat)
    {
        $unitAlat->delete();

        return back()->with('success', 'Unit alat berhasil dihapus.');
    }

    /**
     * Simpan/replace operator grup A/B/C/D untuk sebuah unit alat.
     */
    private function syncOperators(UnitAlat $unitAlat, array $data): void
    {
        foreach (['A' => 'operator_a', 'B' => 'operator_b', 'C' => 'operator_c', 'D' => 'operator_d'] as $grup => $field) {
            $operatorId = $data[$field] ?? null;

            if (empty($operatorId)) {
                UnitOperator::where('unit_alat_id', $unitAlat->id)->where('grup', $grup)->delete();
                continue;
            }

            UnitOperator::updateOrCreate(
                ['unit_alat_id' => $unitAlat->id, 'grup' => $grup],
                ['operator_id' => $operatorId]
            );
        }
    }
}
