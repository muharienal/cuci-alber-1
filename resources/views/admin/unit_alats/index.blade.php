@extends('layouts.admin')

@section('title', 'Unit Alat & Operator')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="card-title">Tambah Unit Alat Baru</h6>
        <form method="POST" action="{{ route('admin.unitAlats.store') }}" class="row g-2">
            @csrf
            <div class="col-md-4">
                <label class="form-label small">Unit Kerja</label>
                <select name="unit_kerja_id" class="form-select" required>
                    <option value="">-- Pilih Unit Kerja --</option>
                    @foreach ($unitKerjas as $uk)
                        <option value="{{ $uk->id }}">{{ $uk->areaKerja->zona->nama }} / {{ $uk->areaKerja->nama }} / {{ $uk->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Jenis Alat</label>
                <select name="jenis_alat_id" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($jenisAlats as $ja)
                        <option value="{{ $ja->id }}">{{ $ja->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">No. Lambung</label>
                <input type="text" name="no_lambung" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Kepemilikan</label>
                <input type="text" name="kepemilikan" class="form-control" placeholder="PCS/WKK/YAYASAN">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Operator Grup A</label>
                <select name="operator_a" class="form-select">
                    <option value="">-</option>
                    @foreach ($operators as $op)
                        <option value="{{ $op->id }}">{{ $op->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup B</label>
                <select name="operator_b" class="form-select">
                    <option value="">-</option>
                    @foreach ($operators as $op)
                        <option value="{{ $op->id }}">{{ $op->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup C</label>
                <select name="operator_c" class="form-select">
                    <option value="">-</option>
                    @foreach ($operators as $op)
                        <option value="{{ $op->id }}">{{ $op->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Operator Grup D</label>
                <select name="operator_d" class="form-select">
                    <option value="">-</option>
                    @foreach ($operators as $op)
                        <option value="{{ $op->id }}">{{ $op->nama }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <p class="text-muted small mt-2 mb-0">Tips: kelola daftar operator terlebih dahulu di menu <strong>Operator</strong> sebelum menugaskannya ke unit di sini.</p>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="unit_kerja_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Unit Kerja --</option>
                    @foreach ($unitKerjas as $uk)
                        <option value="{{ $uk->id }}" {{ request('unit_kerja_id') == $uk->id ? 'selected' : '' }}>{{ $uk->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="jenis_alat_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Jenis Alat --</option>
                    @foreach ($jenisAlats as $ja)
                        <option value="{{ $ja->id }}" {{ request('jenis_alat_id') == $ja->id ? 'selected' : '' }}>{{ $ja->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="q" class="form-control" placeholder="Cari no. lambung..." value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary">Filter</button>
                <a href="{{ route('admin.unitAlats.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                    <th>Zona / Area / Unit Kerja</th>
                    <th>Jenis</th>
                    <th>No. Lambung</th>
                    <th>Kepemilikan</th>
                    <th>Operator (A/B/C/D)</th>
                    <th style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($unitAlats as $ua)
                    @php
                        $opByGrup = $ua->unitOperators->keyBy('grup');
                    @endphp
                    <tr>
                        <td>
                            <div class="small text-muted">{{ $ua->unitKerja->areaKerja->zona->nama ?? '-' }} / {{ $ua->unitKerja->areaKerja->nama ?? '-' }}</div>
                            {{ $ua->unitKerja->nama ?? '-' }}
                        </td>
                        <td>{{ $ua->jenisAlat->nama ?? '-' }}</td>
                        <td>{{ $ua->no_lambung }}</td>
                        <td>{{ $ua->kepemilikan ?? '-' }}</td>
                        <td class="small">
                            @foreach (['A','B','C','D'] as $g)
                                <div><strong>{{ $g }}:</strong> {{ $opByGrup[$g]->operator->nama ?? '-' }}</div>
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUA{{ $ua->id }}">Edit</button>
                            <form action="{{ route('admin.unitAlats.destroy', $ua) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus unit alat ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editUA{{ $ua->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.unitAlats.update', $ua) }}">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Unit Alat - {{ $ua->no_lambung }}</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-6">
                                                <label class="form-label small">Unit Kerja</label>
                                                <select name="unit_kerja_id" class="form-select" required>
                                                    @foreach ($unitKerjas as $uk)
                                                        <option value="{{ $uk->id }}" {{ $uk->id === $ua->unit_kerja_id ? 'selected' : '' }}>{{ $uk->areaKerja->zona->nama }} / {{ $uk->areaKerja->nama }} / {{ $uk->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">Jenis Alat</label>
                                                <select name="jenis_alat_id" class="form-select" required>
                                                    @foreach ($jenisAlats as $ja)
                                                        <option value="{{ $ja->id }}" {{ $ja->id === $ua->jenis_alat_id ? 'selected' : '' }}>{{ $ja->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label small">No. Lambung</label>
                                                <input type="text" name="no_lambung" class="form-control" value="{{ $ua->no_lambung }}" required>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-2">
                                            <div class="col-md-4">
                                                <label class="form-label small">Kepemilikan</label>
                                                <input type="text" name="kepemilikan" class="form-control" value="{{ $ua->kepemilikan }}">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label small">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control" value="{{ $ua->keterangan }}">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row g-2">
                                            @foreach (['A','B','C','D'] as $g)
                                                <div class="col-md-3">
                                                    <label class="form-label small">Operator Grup {{ $g }}</label>
                                                    <select name="operator_{{ strtolower($g) }}" class="form-select">
                                                        <option value="">-</option>
                                                        @foreach ($operators as $op)
                                                            <option value="{{ $op->id }}" {{ (optional($opByGrup[$g] ?? null)->operator_id) === $op->id ? 'selected' : '' }}>{{ $op->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach
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
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data unit alat.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        {{ $unitAlats->links() }}
    </div>
</div>
@endsection
