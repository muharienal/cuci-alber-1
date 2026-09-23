@extends('layouts.admin')

@section('title', 'Master Area Kerja')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Area Kerja Baru</h6>
        <form method="POST" action="{{ route('admin.areaKerjas.store') }}" class="row g-2">
            @csrf
            <div class="col-md-4">
                <select name="zona_id" class="form-select" required>
                    <option value="">-- Pilih Zona --</option>
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}">{{ $zona->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Gudang 1" required>
            </div>
            <div class="col-md-3">
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
                    <th>Zona</th>
                    <th>Nama Area Kerja</th>
                    <th>Jumlah Unit Kerja</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($areaKerjas as $i => $area)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $area->zona->nama ?? '-' }}</td>
                        <td>{{ $area->nama }}</td>
                        <td>{{ $area->unit_kerjas_count }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editArea{{ $area->id }}">Edit</button>
                            <form action="{{ route('admin.areaKerjas.destroy', $area) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus area kerja ini beserta unit kerja di dalamnya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editArea{{ $area->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.areaKerjas.update', $area) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Area Kerja</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Zona</label>
                                            <select name="zona_id" class="form-select" required>
                                                @foreach ($zonas as $zona)
                                                    <option value="{{ $zona->id }}" {{ $zona->id === $area->zona_id ? 'selected' : '' }}>{{ $zona->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Nama Area Kerja</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $area->nama }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data area kerja.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
