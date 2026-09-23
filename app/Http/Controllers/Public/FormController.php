<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AreaKerja;
use App\Models\Operator;
use App\Models\Pengawas;
use App\Models\Submission;
use App\Models\UnitAlat;
use App\Models\Zona;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Tampilkan halaman form publik (wizard 1 halaman, tanpa login).
     */
    public function index()
    {
        $zonas = Zona::orderBy('nama')->get();
        $pengawasList = Pengawas::orderBy('nama')->get();
        $operators = Operator::orderBy('nama')->get(['id', 'nama']);

        return view('public.form', compact('zonas', 'pengawasList', 'operators'));
    }

    /**
     * AJAX: ambil daftar Area Kerja berdasarkan Zona yang dipilih.
     */
    public function getAreaKerja(Zona $zona)
    {
        $areaKerjas = $zona->areaKerjas()->orderBy('nama')->get(['id', 'nama']);

        return response()->json($areaKerjas);
    }

    /**
     * AJAX: ambil daftar Unit Alat (No. Lambung) berdasarkan Area Kerja + jenis alat
     * (forklift atau wheel-loader), sesuai alur form asli yang langsung menuju
     * "No Lambung Unit" tanpa menanyakan Unit Kerja secara eksplisit.
     */
    public function getUnitAlatByJenis(AreaKerja $areaKerja, string $jenis)
    {
        $namaJenis = $jenis === 'wheel-loader' ? 'Wheel Loader' : 'Forklift';

        $unitAlats = UnitAlat::query()
            ->whereHas('unitKerja', fn ($q) => $q->where('area_kerja_id', $areaKerja->id))
            ->whereHas('jenisAlat', fn ($q) => $q->where('nama', $namaJenis))
            ->orderBy('no_lambung')
            ->get(['id', 'no_lambung', 'kepemilikan']);

        $unitAlats = $unitAlats->map(fn ($u) => [
            'id' => $u->id,
            'label' => $u->no_lambung . ($u->kepemilikan ? ' (' . $u->kepemilikan . ')' : ''),
        ]);

        return response()->json($unitAlats);
    }

    /**
     * AJAX: ambil roster operator grup A/B/C/D untuk unit alat yang dipilih,
     * dipakai untuk otomatis menyarankan/prefill dropdown operator grup.
     */
    public function getOperators(UnitAlat $unitAlat)
    {
        $ops = $unitAlat->unitOperators()
            ->with('operator:id,nama')
            ->get()
            ->mapWithKeys(fn ($uo) => [
                $uo->grup => ['operator_id' => $uo->operator_id, 'nama' => $uo->operator->nama ?? '-'],
            ]);

        return response()->json($ops);
    }

    /**
     * Simpan jawaban form dari pengunjung (tanpa login).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_alat_id' => ['required', 'exists:unit_alats,id'],
            'pengawas_id' => ['required', 'exists:pengawas,id'],
            'shift' => ['required', 'in:1,2,3'],
            'operator_nd_id' => ['nullable', 'exists:operators,id'],
            'operator_grup_a_id' => ['nullable', 'exists:operators,id'],
            'operator_grup_b_id' => ['nullable', 'exists:operators,id'],
            'operator_grup_c_id' => ['nullable', 'exists:operators,id'],
            'operator_grup_d_id' => ['nullable', 'exists:operators,id'],
            'foto' => ['required', 'array', 'min:1', 'max:10'],
            'foto.*' => ['image', 'max:5120'], // tiap foto maks 5MB, maksimal 10 foto per isian
        ]);

        $unitAlat = UnitAlat::with(['unitKerja.areaKerja.zona', 'jenisAlat'])->findOrFail($validated['unit_alat_id']);

        $submission = Submission::create([
            'unit_alat_id' => $unitAlat->id,
            'pengawas_id' => $validated['pengawas_id'],
            'shift' => $validated['shift'],
            'operator_nd_id' => $validated['operator_nd_id'] ?? null,
            'operator_grup_a_id' => $validated['operator_grup_a_id'] ?? null,
            'operator_grup_b_id' => $validated['operator_grup_b_id'] ?? null,
            'operator_grup_c_id' => $validated['operator_grup_c_id'] ?? null,
            'operator_grup_d_id' => $validated['operator_grup_d_id'] ?? null,
            'zona_snapshot' => $unitAlat->unitKerja->areaKerja->zona->nama ?? null,
            'area_kerja_snapshot' => $unitAlat->unitKerja->areaKerja->nama ?? null,
            'unit_kerja_snapshot' => $unitAlat->unitKerja->nama ?? null,
            'jenis_alat_snapshot' => $unitAlat->jenisAlat->nama ?? null,
            'no_lambung_snapshot' => $unitAlat->no_lambung,
        ]);

        foreach ($request->file('foto', []) as $file) {
            $path = $file->store('foto-cuci-alat', 'public');
            $submission->photos()->create(['path' => $path]);
        }

        return redirect()->route('form.thanks');
    }

    public function thanks()
    {
        return view('public.thanks');
    }
}
