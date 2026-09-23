@extends('layouts.admin')

@section('title', 'Master Zona')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Zona Baru</h6>
        <form method="POST" action="{{ route('admin.zonas.store') }}" class="row g-2">
            @csrf
            <div class="col-md-8">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: ZONA 1A" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Nama Zona</th>
                    <th>Jumlah Area Kerja</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($zonas as $i => $zona)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $zona->nama }}</td>
                        <td>{{ $zona->area_kerjas_count }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editZona{{ $zona->id }}">Edit</button>
                            <form action="{{ route('admin.zonas.destroy', $zona) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus zona ini? Semua area kerja & unit di bawahnya juga akan terhapus.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editZona{{ $zona->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.zonas.update', $zona) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Zona</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="nama" class="form-control" value="{{ $zona->nama }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada data zona.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
