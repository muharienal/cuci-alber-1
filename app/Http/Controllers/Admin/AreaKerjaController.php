<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaKerja;
use App\Models\Zona;
use Illuminate\Http\Request;

class AreaKerjaController extends Controller
{
    public function index()
    {
        $areaKerjas = AreaKerja::with('zona')->withCount('unitKerjas')
            ->orderBy('zona_id')->orderBy('nama')->get();
        $zonas = Zona::orderBy('nama')->get();

        return view('admin.area_kerjas.index', compact('areaKerjas', 'zonas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zona_id' => ['required', 'exists:zonas,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        AreaKerja::create($data);

        return back()->with('success', 'Area kerja berhasil ditambahkan.');
    }

    public function update(Request $request, AreaKerja $areaKerja)
    {
        $data = $request->validate([
            'zona_id' => ['required', 'exists:zonas,id'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $areaKerja->update($data);

        return back()->with('success', 'Area kerja berhasil diperbarui.');
    }

    public function destroy(AreaKerja $areaKerja)
    {
        $areaKerja->delete();

        return back()->with('success', 'Area kerja berhasil dihapus.');
    }
}
