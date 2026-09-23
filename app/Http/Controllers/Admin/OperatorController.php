<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Operator::withCount('unitOperators')->orderBy('nama');

        if ($search = $request->get('q')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $operators = $query->paginate(25)->withQueryString();

        return view('admin.operators.index', compact('operators'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:50'],
        ]);

        Operator::create($data);

        return back()->with('success', 'Operator berhasil ditambahkan.');
    }

    public function update(Request $request, Operator $operator)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:50'],
        ]);

        $operator->update($data);

        return back()->with('success', 'Operator berhasil diperbarui.');
    }

    public function destroy(Operator $operator)
    {
        $operator->delete();

        return back()->with('success', 'Operator berhasil dihapus.');
    }
}
