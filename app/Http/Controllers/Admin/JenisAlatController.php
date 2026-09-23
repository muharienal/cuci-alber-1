<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisAlat;
use Illuminate\Http\Request;

class JenisAlatController extends Controller
{
    public function index()
    {
        $jenisAlats = JenisAlat::withCount('unitAlats')->orderBy('nama')->get();

        return view('admin.jenis_alats.index', compact('jenisAlats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_alats,nama'],
        ]);

        JenisAlat::create($data);

        return back()->with('success', 'Jenis alat berhasil ditambahkan.');
    }

    public function update(Request $request, JenisAlat $jenisAlat)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:jenis_alats,nama,' . $jenisAlat->id],
        ]);

        $jenisAlat->update($data);

        return back()->with('success', 'Jenis alat berhasil diperbarui.');
    }

    public function destroy(JenisAlat $jenisAlat)
    {
        $jenisAlat->delete();

        return back()->with('success', 'Jenis alat berhasil dihapus.');
    }
}
