<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaKerja;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::with('areaKerja.zona')->withCount('unitAlats')
            ->orderBy('area_kerja_id')->orderBy('nama')->get();
        $areaKerjas = AreaKerja::with('zona')->orderBy('nama')->get();

        return view('admin.unit_kerjas.index', compact('unitKerjas', 'areaKerjas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'area_kerja_id' => ['required', 'exists:area_kerjas,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        UnitKerja::create($data);

        return back()->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $data = $request->validate([
            'area_kerja_id' => ['required', 'exists:area_kerjas,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $unitKerja->update($data);

        return back()->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();

        return back()->with('success', 'Unit kerja berhasil dihapus.');
    }
}
