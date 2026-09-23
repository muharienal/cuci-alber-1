@extends('layouts.admin')

@section('title', 'Data Cuci Alat')

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="zona" class="form-select">
                    <option value="">-- Semua Zona --</option>
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->nama }}" {{ request('zona') === $zona->nama ? 'selected' : '' }}>{{ $zona->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="shift" class="form-select">
                    <option value="">-- Semua Shift --</option>
                    @foreach (['1','2','3'] as $sh)
                        <option value="{{ $sh }}" {{ request('shift') === $sh ? 'selected' : '' }}>Shift {{ $sh }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary">Filter</button>
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-outline-secondary">Reset</a>
                <a href="{{ route('admin.submissions.export', request()->query()) }}" class="btn btn-success">Export CSV</a>
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
                    <th>Waktu</th>
                    <th>Zona / Area</th>
                    <th>Unit Kerja</th>
                    <th>Jenis / No. Lambung</th>
                    <th>Pengawas</th>
                    <th>Shift</th>
                    <th>Operator</th>
                    <th>Foto</th>
                    <th style="width:70px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $s)
                    <tr>
                        <td class="small">{{ $s->created_at->format('d-m-Y H:i') }}</td>
                        <td class="small">{{ $s->zona_snapshot }}<br><span class="text-muted">{{ $s->area_kerja_snapshot }}</span></td>
                        <td class="small">{{ $s->unit_kerja_snapshot }}</td>
                        <td class="small">{{ $s->jenis_alat_snapshot }}<br><strong>{{ $s->no_lambung_snapshot }}</strong></td>
                        <td class="small">{{ $s->pengawas->nama ?? '-' }}</td>
                        <td><span class="badge bg-secondary">Shift {{ $s->shift }}</span></td>
                        <td class="small">{{ $s->operator_summary }}</td>
                        <td>
                            @forelse ($s->photos as $photo)
                                <a href="{{ Storage::url($photo->path) }}" target="_blank" class="d-inline-block me-1 mb-1">
                                    <img src="{{ Storage::url($photo->path) }}" style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                </a>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>
                            <form action="{{ route('admin.submissions.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus data isian ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted">Belum ada data isian.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        {{ $submissions->links() }}
    </div>
</div>
@endsection
