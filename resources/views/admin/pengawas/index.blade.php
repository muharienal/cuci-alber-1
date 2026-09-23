@extends('layouts.admin')

@section('title', 'Master Pengawas')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Pengawas Baru</h6>
        <form method="POST" action="{{ route('admin.pengawas.store') }}" class="row g-2">
            @csrf
            <div class="col-md-6">
                <input type="text" name="nama" class="form-control" placeholder="Nama Pengawas" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="wilayah" class="form-control" placeholder="Wilayah (opsional), contoh: I A">
            </div>
            <div class="col-md-2">
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
                    <th>Nama Pengawas</th>
                    <th>Wilayah</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengawasList as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->wilayah ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editP{{ $p->id }}">Edit</button>
                            <form action="{{ route('admin.pengawas.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengawas ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editP{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.pengawas.update', $p) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Pengawas</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">Wilayah</label>
                                            <input type="text" name="wilayah" class="form-control" value="{{ $p->wilayah }}">
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
                    <tr><td colspan="4" class="text-center text-muted">Belum ada data pengawas.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
