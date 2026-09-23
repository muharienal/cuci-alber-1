@extends('layouts.admin')

@section('title', 'Master Operator')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Operator Baru</h6>
        <form method="POST" action="{{ route('admin.operators.store') }}" class="row g-2">
            @csrf
            <div class="col-md-6">
                <input type="text" name="nama" class="form-control" placeholder="Nama Operator" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="no_hp" class="form-control" placeholder="No. HP (opsional)">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="input-group" style="max-width: 320px;">
                <input type="text" name="q" class="form-control" placeholder="Cari nama operator..." value="{{ request('q') }}">
                <button class="btn btn-outline-secondary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Jml Unit Ditugaskan</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($operators as $i => $op)
                    <tr>
                        <td>{{ $operators->firstItem() + $i }}</td>
                        <td>{{ $op->nama }}</td>
                        <td>{{ $op->no_hp ?? '-' }}</td>
                        <td>{{ $op->unit_operators_count }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editOp{{ $op->id }}">Edit</button>
                            <form action="{{ route('admin.operators.destroy', $op) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus operator ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editOp{{ $op->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.operators.update', $op) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Operator</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $op->nama }}" required>
                                        </div>
                                        <div>
                                            <label class="form-label">No. HP</label>
                                            <input type="text" name="no_hp" class="form-control" value="{{ $op->no_hp }}">
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
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data operator.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{ $operators->links() }}
    </div>
</div>
@endsection
