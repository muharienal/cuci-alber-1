<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function index()
    {
        $zonas = Zona::withCount('areaKerjas')->orderBy('nama')->get();

        return view('admin.zonas.index', compact('zonas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:zonas,nama'],
        ]);

        Zona::create($data);

        return back()->with('success', 'Zona berhasil ditambahkan.');
    }

    public function update(Request $request, Zona $zona)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:zonas,nama,' . $zona->id],
        ]);

        $zona->update($data);

        return back()->with('success', 'Zona berhasil diperbarui.');
    }

    public function destroy(Zona $zona)
    {
        $zona->delete();

        return back()->with('success', 'Zona berhasil dihapus.');
    }
}
