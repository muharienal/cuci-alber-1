@extends('layouts.public')

@section('title', 'Terima Kasih - Cuci Alber')

@push('styles')
<style>
    .thanks-card {
        background: #fff; border-radius: var(--radius);
        box-shadow: 0 25px 60px -15px rgba(10,22,40,.35), 0 8px 20px -8px rgba(10,22,40,.15);
        padding: 3rem 1.75rem; text-align: center;
    }
    .thanks-icon {
        width: 76px; height: 76px; border-radius: 50%; margin: 0 auto 1.25rem;
        background: linear-gradient(135deg, var(--orange-500), var(--amber-400));
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2.1rem;
        box-shadow: 0 10px 25px -6px rgba(249,115,22,.5);
    }
    .btn-new {
        background: var(--navy-800); border-color: var(--navy-800); color: #fff;
        border-radius: 12px; font-weight: 700; padding: .7rem 1.6rem;
    }
    .btn-new:hover { background: var(--navy-900); border-color: var(--navy-900); color: #fff; }
</style>
@endpush

@section('content')
<div class="thanks-card">
    <div class="thanks-icon"><i class="bi bi-check-lg"></i></div>
    <h5 class="fw-bold" style="color: var(--navy-900);">Terima kasih, data cuci alat berat sudah tersimpan.</h5>
    <p class="text-muted">Isian Anda beserta foto bukti sudah kami catat dan dapat dilihat oleh admin.</p>
    <a href="{{ route('form.index') }}" class="btn btn-new mt-2"><i class="bi bi-plus-lg"></i> Isi Data Baru</a>
</div>
@endsection
