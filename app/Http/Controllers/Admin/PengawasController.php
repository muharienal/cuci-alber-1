<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengawas;
use Illuminate\Http\Request;

class PengawasController extends Controller
{
    public function index()
    {
        $pengawasList = Pengawas::orderBy('nama')->get();

        return view('admin.pengawas.index', compact('pengawasList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'wilayah' => ['nullable', 'string', 'max:100'],
        ]);

        Pengawas::create($data);

        return back()->with('success', 'Pengawas berhasil ditambahkan.');
    }

    public function update(Request $request, Pengawas $pengawas)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'wilayah' => ['nullable', 'string', 'max:100'],
        ]);

        $pengawas->update($data);

        return back()->with('success', 'Pengawas berhasil diperbarui.');
    }

    public function destroy(Pengawas $pengawas)
    {
        $pengawas->delete();

        return back()->with('success', 'Pengawas berhasil dihapus.');
    }
}
