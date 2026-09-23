@extends('layouts.admin')

@section('title', 'Master Jenis Alat')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Jenis Alat Baru</h6>
        <form method="POST" action="{{ route('admin.jenisAlats.store') }}" class="row g-2">
            @csrf
            <div class="col-md-8">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Forklift, Wheel Loader, Dump Truck" required>
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
                    <th>Nama Jenis Alat</th>
                    <th>Jumlah Unit</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenisAlats as $i => $ja)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ja->nama }}</td>
                        <td>{{ $ja->unit_alats_count }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editJA{{ $ja->id }}">Edit</button>
                            <form action="{{ route('admin.jenisAlats.destroy', $ja) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jenis alat ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editJA{{ $ja->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.jenisAlats.update', $ja) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Jenis Alat</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="nama" class="form-control" value="{{ $ja->nama }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada data jenis alat.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
