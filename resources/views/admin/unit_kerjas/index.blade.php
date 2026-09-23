@extends('layouts.admin')

@section('title', 'Master Unit Kerja')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Unit Kerja Baru</h6>
        <form method="POST" action="{{ route('admin.unitKerjas.store') }}" class="row g-2">
            @csrf
            <div class="col-12 col-md-5">
                <select name="area_kerja_id" class="form-select" required>
                    <option value="">-- Pilih Area Kerja --</option>
                    @foreach ($areaKerjas as $area)
                        <option value="{{ $area->id }}">{{ $area->zona->nama }} - {{ $area->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-5">
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Gd. Urea" required>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Zona</th>
                    <th>Area Kerja</th>
                    <th>Unit Kerja</th>
                    <th>Jml Unit Alat</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unitKerjas as $i => $uk)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $uk->areaKerja->zona->nama ?? '-' }}</td>
                        <td>{{ $uk->areaKerja->nama ?? '-' }}</td>
                        <td>{{ $uk->nama }}</td>
                        <td>{{ $uk->unit_alats_count }}</td>
                        <td class="text-nowrap">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUK{{ $uk->id }}">Edit</button>
                            <form action="{{ route('admin.unitKerjas.destroy', $uk) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit kerja ini beserta unit alat di dalamnya?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editUK{{ $uk->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.unitKerjas.update', $uk) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Unit Kerja</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Area Kerja</label>
                                            <select name="area_kerja_id" class="form-select" required>
                                                @foreach ($areaKerjas as $area)
                                                    <option value="{{ $area->id }}" {{ $area->id === $uk->area_kerja_id ? 'selected' : '' }}>{{ $area->zona->nama }} - {{ $area->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label">Nama Unit Kerja</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $uk->nama }}" required>
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
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data unit kerja.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
