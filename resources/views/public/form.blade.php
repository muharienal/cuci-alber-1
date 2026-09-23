@extends('layouts.public')

@section('title', 'Form Cuci Alat Berat - Cuci Alber')

@push('styles')
<style>
    /* Card tinggi tetap (mengikuti viewport, dibatasi maksimal) - header & step
       indicator diam di atas, hanya konten step (termasuk tombolnya) yang scroll
       di dalam. Ini mencegah halaman/body ikut scroll (yang di mobile bisa bikin
       header "ketutup" karena body di-center secara vertikal). */
    .card-shell {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: 0 25px 60px -15px rgba(10,22,40,.35), 0 8px 20px -8px rgba(10,22,40,.15);
        display: flex;
        flex-direction: column;
        height: min(90vh, 820px);
        min-height: 500px;
    }
    .card-head {
        background: linear-gradient(135deg, var(--navy-900) 0%, var(--navy-700) 55%, var(--navy-500) 100%);
        color: #fff;
        padding: 1.6rem 2rem 1.3rem;
        position: relative;
        border-radius: var(--radius) var(--radius) 0 0;
        flex: none;
    }
    .card-head::after {
        content: "";
        position: absolute; inset: auto 0 0 0; height: 4px;
        background: linear-gradient(90deg, var(--orange-500), var(--amber-400));
    }
    .card-head h1 { font-size: 1.45rem; font-weight: 800; margin: 0; letter-spacing: -.01em; }
    .card-head p { margin: .35rem 0 0; opacity: .85; font-size: .93rem; }
    .badge-shift {
        display: inline-flex; align-items: center; gap: .4rem;
        background: rgba(251,191,36,.16); border: 1px solid rgba(251,191,36,.4); color: var(--amber-400);
        padding: .35rem .85rem; border-radius: 999px; font-size: .78rem; font-weight: 700; margin-top: .9rem;
    }

    .card-body-pad {
        padding: 1.5rem 1.35rem 1.75rem;
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }
    @media (min-width: 576px) { .card-body-pad { padding: 1.75rem 2.25rem 2rem; } }

    /* Step indicator - diam di atas, bukan bagian dari area yang scroll */
    .steps-track { position: relative; display: flex; justify-content: space-between; margin-bottom: 1.6rem; flex: none; }
    .steps-track::before {
        content: ""; position: absolute; top: 18px; left: 8%; right: 8%; height: 2px; background: #e2e8f0; z-index: 0;
    }
    .step-dot { position: relative; z-index: 1; flex: 1; text-align: center; }
    .step-circle {
        width: 36px; height: 36px; border-radius: 50%; margin: 0 auto;
        display: flex; align-items: center; justify-content: center;
        background: #fff; border: 2px solid #dbe2ee; color: #94a3b8;
        font-weight: 700; font-size: .9rem; transition: all .2s;
    }
    .step-dot.active .step-circle { border-color: var(--orange-500); background: var(--orange-500); color: #fff; box-shadow: 0 0 0 4px rgba(249,115,22,.18); }
    .step-dot.done .step-circle { border-color: var(--navy-700); background: var(--navy-700); color: #fff; }
    .step-label { font-size: .8rem; color: #94a3b8; margin-top: .4rem; font-weight: 600; }
    .step-dot.active .step-label { color: var(--navy-800); }
    .step-dot.done .step-label { color: var(--navy-600); }

    /* Area konten step yang scroll di DALAM card (bukan halaman di luar).
       Tombol Kembali/Lanjut/Kirim ikut di dalam sini (menempel di akhir konten
       tiap step), jadi tidak ada celah kosong aneh untuk step yang isinya sedikit. */
    .step-scroll {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        padding-right: .5rem;
        margin-right: -.5rem;
    }
    .step-scroll::-webkit-scrollbar { width: 7px; }
    .step-scroll::-webkit-scrollbar-track { background: transparent; }
    .step-scroll::-webkit-scrollbar-thumb { background: #dbe2ee; border-radius: 999px; }
    .step-scroll::-webkit-scrollbar-thumb:hover { background: var(--navy-500); }
    .step-scroll { scrollbar-width: thin; scrollbar-color: #dbe2ee transparent; }

    .step-nav-row {
        display: flex; align-items: center; justify-content: space-between;
        gap: .75rem; padding-top: 1.4rem; margin-top: 1.5rem;
        border-top: 1px solid #eef1f6;
    }

    .section-title { font-weight: 800; color: var(--navy-900); font-size: 1.18rem; margin-bottom: 1rem; }
    .section-title.has-hint { margin-bottom: .2rem; }
    .form-label { font-weight: 700; color: var(--navy-800); font-size: .87rem; margin-bottom: .45rem; }
    .required::after { content: " *"; color: var(--orange-600); }
    .field-hint { font-size: .8rem; color: var(--muted); }

    .form-select, .form-control {
        border-radius: 11px; height: 44px; padding: 0 .9rem; border: 1.6px solid #dbe2ee; font-size: .92rem;
    }
    .form-select:focus, .form-control:focus {
        border-color: var(--navy-600); box-shadow: 0 0 0 .2rem rgba(29,63,122,.14);
    }

    /* Chip / pill selectable buttons */
    .chip-input { position: absolute; opacity: 0; pointer-events: none; }
    .chip-grid {
        display: flex; flex-wrap: wrap; gap: .6rem; justify-content: center;
    }
    .chip-grid-item { flex: 0 0 calc(50% - .3rem); }
    @media (min-width: 380px) { .chip-grid-item { flex: 0 0 calc(33.333% - .4rem); } }
    .chip-label {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        border: 1.6px solid #dbe2ee; border-radius: 11px; height: 44px; padding: 0 .6rem;
        font-weight: 700; font-size: .9rem; color: var(--navy-700); background: #fff;
        cursor: pointer; text-align: center; transition: all .15s; width: 100%;
    }
    .chip-label:hover { border-color: var(--navy-500); }
    .chip-input:checked + .chip-label {
        background: var(--orange-500); border-color: var(--orange-500); color: #fff;
        box-shadow: 0 6px 16px -4px rgba(249,115,22,.5);
    }
    .chip-lg { height: 52px; font-size: 1rem; }

    .btn-nav-next {
        background: var(--orange-500); border-color: var(--orange-500); color: #fff;
        border-radius: 11px; font-weight: 700; height: 44px; padding: 0 1.5rem; font-size: .92rem;
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    }
    .btn-nav-next:hover { background: var(--orange-600); border-color: var(--orange-600); color: #fff; }
    .btn-nav-prev {
        background: #fff; border: 1.6px solid var(--navy-700); color: var(--navy-800);
        border-radius: 11px; font-weight: 700; height: 44px; padding: 0 1.4rem; font-size: .92rem;
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    }
    .btn-nav-prev:hover { background: var(--navy-800); border-color: var(--navy-800); color: #fff; }

    .upload-zone {
        border: 2px dashed #cbd5e1; border-radius: 16px; padding: 2.5rem 1.5rem; text-align: center;
        cursor: pointer; transition: all .15s; background: #f8fafc;
    }
    .upload-zone:hover { border-color: var(--orange-500); background: #fff7ed; }
    .photo-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: .75rem;
    }
    .photo-thumb { position: relative; border-radius: 12px; overflow: hidden; aspect-ratio: 1/1; background: #f1f5f9; }
    .photo-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .photo-thumb .photo-remove {
        position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; border-radius: 50%;
        background: rgba(15,23,42,.75); color: #fff; border: none; font-size: .9rem; line-height: 1;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .photo-thumb .photo-remove:hover { background: var(--orange-600); }
    .upload-icon { font-size: 2.3rem; color: var(--navy-500); }

    /* Ringkasan (step 5) - satu grid rata berisi tile per field.
       Judul section jadi baris pemisah full-width; field sesudahnya otomatis
       melipat ke kolom berikutnya, sehingga section besar (Petugas) melebar
       ke samping alih-alih menjulang tinggi sendirian ke bawah. */
    .summary-box {
        border: 1px solid #e2e8f0; border-radius: 16px; background: #f8fafc; padding: 1.5rem;
    }
    .summary-flow { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .summary-label-row {
        grid-column: 1 / -1;
        font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .05em;
        color: var(--navy-600); padding-bottom: .5rem; border-bottom: 1px solid #dbe2ee; margin-top: 1.4rem;
    }
    .summary-label-row:first-child { margin-top: 0; }
    .summary-tile {
        background: #fff; border: 1px solid #e5e9f2; border-radius: 12px; padding: .75rem .9rem; min-width: 0;
    }
    .summary-tile .t-label { font-size: .75rem; color: var(--muted); margin-bottom: .15rem; }
    .summary-tile .t-value {
        font-size: .95rem; font-weight: 700; color: var(--navy-900); overflow-wrap: break-word; line-height: 1.3;
    }
    .summary-photo-row {
        grid-column: 1 / -1; display: grid; grid-template-columns: repeat(auto-fill, minmax(90px, 1fr)); gap: .6rem;
    }
    .summary-photo-row img {
        width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 10px; border: 1px solid #e5e9f2; display: block;
    }
    @media (max-width: 420px) {
        .summary-flow { grid-template-columns: 1fr; }
    }

    .alert-soft {
        background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412;
        border-radius: 12px; font-size: .88rem; line-height: 1.4;
    }

    /* Choices.js theme override */
    .choices__inner { border-radius: 11px !important; border: 1.6px solid #dbe2ee !important; min-height: 44px !important; height: 44px !important; padding: .3rem .8rem !important; font-size: .92rem; display: flex !important; align-items: center; }
    .choices.is-focused .choices__inner { border-color: var(--navy-600) !important; box-shadow: 0 0 0 .2rem rgba(29,63,122,.14); }
    .choices__list--dropdown { border-radius: 12px !important; overflow: hidden; border-color: #dbe2ee !important; }
    .choices__list--dropdown .choices__item--selectable.is-highlighted { background: var(--navy-700) !important; color: #fff; }
    .choices__list--dropdown .choices__item--selectable::after { display: none; }
    .is-disabled .choices__inner { background: #f1f5f9 !important; }
    .choices.is-disabled { opacity: 1 !important; }
    .choices.is-disabled .choices__inner { opacity: 1 !important; }
    .choices__list--single .choices__item.choices__placeholder,
    .choices__placeholder { color: var(--ink) !important; opacity: 1 !important; }

    @media (max-width: 420px) {
        .step-label { display: none; }
        .steps-track::before { left: 12%; right: 12%; }
        .card-head { padding: 1.35rem 1.5rem 1.2rem; }
        .card-head h1 { font-size: 1.2rem; }
    }
</style>
@endpush

@section('content')
<div class="card-shell">
    <div class="card-head">
        <h1 class="mb-0">Form Cuci Alat Berat</h1>
        <p>Isi data unit, petugas, dan bukti foto cuci alat berat Anda.</p>
        <span class="badge-shift"><i class="bi bi-clock-history"></i> Wajib diisi pada waktu akhir shift</span>
    </div>

    <div class="card-body-pad">
        <div class="steps-track" id="stepIndicator">
            @foreach (['Lokasi', 'Unit', 'Petugas', 'Foto', 'Ringkasan'] as $i => $label)
                <div class="step-dot" data-step="{{ $i + 1 }}">
                    <div class="step-circle">{{ $i + 1 }}</div>
                    <div class="step-label">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($errors->any())
            <div class="alert alert-danger small mb-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="step-scroll" id="stepScroll">
        <form method="POST" action="{{ route('form.store') }}" enctype="multipart/form-data" id="formCuciAlber">
            @csrf

            {{-- STEP 1: LOKASI --}}
                <div class="form-step" data-step="1">
                    <div class="section-title">Lokasi Kerja</div>

                    <div class="mb-3">
                        <label class="form-label required">Zona Kerja</label>
                        <div class="chip-grid">
                            @foreach ($zonas as $zona)
                                <div class="chip-grid-item">
                                    <input type="radio" class="chip-input" name="zona_id" id="zona{{ $zona->id }}" value="{{ $zona->id }}" required>
                                    <label class="chip-label" for="zona{{ $zona->id }}">{{ $zona->nama }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label required">Area Kerja</label>
                        <select id="area_kerja_id" class="form-select" required disabled>
                            <option value="">-- Pilih Zona terlebih dahulu --</option>
                        </select>
                    </div>

                    <div class="step-nav-row justify-content-end">
                        <button type="button" class="btn btn-nav-next next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>

                {{-- STEP 2: UNIT --}}
                <div class="form-step d-none" data-step="2">
                    <div class="section-title has-hint">No. Lambung Unit yang Akan Dicuci</div>
                    <p class="field-hint mb-3">Pilih salah satu jenis alat, lalu pilih no. lambung unitnya.</p>

                    <div class="mb-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="chip-input" name="jenis_alat_pilih" id="jenisForklift" value="forklift" required>
                                <label class="chip-label chip-lg" for="jenisForklift"><i class="bi bi-forklift"></i> Forklift</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="chip-input" name="jenis_alat_pilih" id="jenisWheelLoader" value="wheel-loader" required>
                                <label class="chip-label chip-lg" for="jenisWheelLoader"><i class="bi bi-truck"></i> Wheel Loader</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label required">No. Lambung Unit</label>
                        <select id="unit_alat_select" class="form-select" required disabled>
                            <option value="">-- Pilih Area Kerja &amp; Jenis Alat terlebih dahulu --</option>
                        </select>
                        <input type="hidden" name="unit_alat_id" id="unit_alat_id">
                    </div>

                    <div class="step-nav-row">
                        <button type="button" class="btn btn-nav-prev prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
                        <button type="button" class="btn btn-nav-next next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>

                {{-- STEP 3: PETUGAS --}}
                <div class="form-step d-none" data-step="3">
                    <div class="section-title has-hint">Operator Alat Berat</div>
                    <p class="field-hint mb-3">Pilih nama operator yang mencuci alat berat tersebut sesuai grup masing-masing.</p>

                    @php
                        $operatorOptionsHtml = '<option value="">-</option>';
                        foreach ($operators as $op) {
                            $operatorOptionsHtml .= '<option value="' . $op->id . '">' . e($op->nama) . '</option>';
                        }
                    @endphp

                    <div class="row g-3 gy-3">
                        <div class="col-sm-6">
                            <label class="form-label required">Pengawas</label>
                            <select name="pengawas_id" id="pengawas_id" class="form-select" required>
                                <option value="">-- Pilih Pengawas --</option>
                                @foreach ($pengawasList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}{{ $p->wilayah ? ' (' . $p->wilayah . ')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label required">Shift</label>
                            <div class="row g-2">
                                @foreach (['1','2','3'] as $sh)
                                    <div class="col-4">
                                        <input type="radio" class="chip-input" name="shift" id="shift{{ $sh }}" value="{{ $sh }}" required>
                                        <label class="chip-label" for="shift{{ $sh }}">Shift {{ $sh }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Operator ND</label>
                            <select name="operator_nd_id" id="operator_nd" class="operator-select form-select">{!! $operatorOptionsHtml !!}</select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Operator Grup A</label>
                            <select name="operator_grup_a_id" id="operator_grup_A" class="operator-select form-select">{!! $operatorOptionsHtml !!}</select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Operator Grup B</label>
                            <select name="operator_grup_b_id" id="operator_grup_B" class="operator-select form-select">{!! $operatorOptionsHtml !!}</select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Operator Grup C</label>
                            <select name="operator_grup_c_id" id="operator_grup_C" class="operator-select form-select">{!! $operatorOptionsHtml !!}</select>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Operator Grup D</label>
                            <select name="operator_grup_d_id" id="operator_grup_D" class="operator-select form-select">{!! $operatorOptionsHtml !!}</select>
                        </div>
                    </div>

                    <div class="step-nav-row">
                        <button type="button" class="btn btn-nav-prev prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
                        <button type="button" class="btn btn-nav-next next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>

                {{-- STEP 4: FOTO --}}
                <div class="form-step d-none" data-step="4">
                    <div class="section-title">Foto Cuci Alat</div>
                    <div class="alert-soft p-2 px-3 mb-3"><i class="bi bi-exclamation-triangle"></i> Alat harus terlihat bersih pada foto. Bisa pilih lebih dari satu foto sekaligus.</div>

                    <div class="mb-3">
                        <label class="form-label required">Foto Cuci Alat (bisa lebih dari 1)</label>

                        <div id="photoGrid" class="photo-grid mb-2"></div>

                        <div class="upload-zone" id="dropZone">
                            <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                            <div class="fw-semibold mt-1" style="color: var(--navy-800);">Klik untuk pilih foto</div>
                            <div class="field-hint">Bisa pilih beberapa foto sekaligus &middot; JPG/PNG, maks. 5MB/foto</div>
                            <input type="file" id="fotoInput" name="foto[]" accept="image/*" class="d-none" multiple>
                        </div>
                    </div>

                    <div class="step-nav-row">
                        <button type="button" class="btn btn-nav-prev prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
                        <button type="button" class="btn btn-nav-next next-step">Lanjut <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>

                {{-- STEP 5: RINGKASAN --}}
                <div class="form-step d-none" data-step="5">
                    <div class="section-title has-hint">Ringkasan Isian</div>
                    <p class="field-hint mb-3">Periksa kembali data di bawah ini sebelum mengirim. Tekan "Kembali" bila ada yang perlu diperbaiki.</p>

                    <div class="summary-box">
                        <div class="summary-flow">
                            <div class="summary-label-row">Lokasi &amp; Unit</div>
                            <div class="summary-tile"><div class="t-label">Zona Kerja</div><div class="t-value" id="sumZona">-</div></div>
                            <div class="summary-tile"><div class="t-label">Area Kerja</div><div class="t-value" id="sumArea">-</div></div>
                            <div class="summary-tile"><div class="t-label">Jenis Alat</div><div class="t-value" id="sumJenis">-</div></div>
                            <div class="summary-tile"><div class="t-label">No. Lambung</div><div class="t-value" id="sumUnit">-</div></div>

                            <div class="summary-label-row">Petugas</div>
                            <div class="summary-tile"><div class="t-label">Pengawas</div><div class="t-value" id="sumPengawas">-</div></div>
                            <div class="summary-tile"><div class="t-label">Shift</div><div class="t-value" id="sumShift">-</div></div>
                            <div class="summary-tile"><div class="t-label">Operator ND</div><div class="t-value" id="sumOperatorNd">-</div></div>
                            <div class="summary-tile"><div class="t-label">Operator Grup A</div><div class="t-value" id="sumOperatorA">-</div></div>
                            <div class="summary-tile"><div class="t-label">Operator Grup B</div><div class="t-value" id="sumOperatorB">-</div></div>
                            <div class="summary-tile"><div class="t-label">Operator Grup C</div><div class="t-value" id="sumOperatorC">-</div></div>
                            <div class="summary-tile"><div class="t-label">Operator Grup D</div><div class="t-value" id="sumOperatorD">-</div></div>

                            <div class="summary-label-row">Foto Cuci Alat</div>
                            <div class="summary-photo-row" id="sumFotoGrid"></div>
                        </div>
                    </div>

                    <div class="step-nav-row">
                        <button type="button" class="btn btn-nav-prev prev-step"><i class="bi bi-arrow-left"></i> Kembali</button>
                        <button type="submit" class="btn btn-nav-next"><i class="bi bi-send-check"></i> Kirim</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
const totalSteps = 5;
let currentStep = 1;
const stepScrollEl = document.getElementById('stepScroll');

function showStep(step) {
    document.querySelectorAll('.form-step').forEach(el => {
        el.classList.toggle('d-none', parseInt(el.dataset.step) !== step);
    });
    document.querySelectorAll('.step-dot').forEach(el => {
        const s = parseInt(el.dataset.step);
        el.classList.toggle('active', s === step);
        el.classList.toggle('done', s < step);
    });
    currentStep = step;

    // reset posisi scroll konten ke atas setiap ganti step (yang scroll adalah
    // area konten di dalam card, bukan halaman)
    if (stepScrollEl) stepScrollEl.scrollTop = 0;
}

function validateStep(step) {
    if (step === 4) {
        if (typeof selectedFiles === 'undefined' || selectedFiles.length === 0) {
            alert('Mohon pilih minimal 1 foto cuci alat.');
            return false;
        }
        return true;
    }

    const stepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    const requiredEls = stepEl.querySelectorAll('[required]:not(:disabled)');
    for (const el of requiredEls) {
        if (el.type === 'radio') {
            const group = stepEl.querySelectorAll(`[name="${el.name}"]`);
            const checked = Array.from(group).some(r => r.checked);
            if (!checked) { alert('Mohon lengkapi pilihan pada langkah ini.'); return false; }
        } else if (!el.value) {
            // select dibungkus Choices.js (hidden), reportValidity native tidak akan tampil
            alert('Mohon lengkapi field yang wajib diisi (' + (el.previousElementSibling?.textContent || 'kolom ini') + ').');
            return false;
        }
    }
    return true;
}

document.querySelectorAll('.next-step').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!validateStep(currentStep) || currentStep >= totalSteps) return;
        const nextStep = currentStep + 1;
        if (nextStep === totalSteps) updateSummary();
        showStep(nextStep);
    });
});
document.querySelectorAll('.prev-step').forEach(btn => {
    btn.addEventListener('click', () => { if (currentStep > 1) showStep(currentStep - 1); });
});

// ==== STEP 5: Ringkasan - ambil label teks yang sedang terpilih dari step sebelumnya ====
function getCheckedLabel(name) {
    const checked = document.querySelector(`input[name="${name}"]:checked`);
    if (!checked) return '-';
    const label = document.querySelector(`label[for="${checked.id}"]`);
    return label ? label.textContent.trim() : checked.value;
}

function getSelectText(id) {
    const el = document.getElementById(id);
    if (!el || !el.value) return '-';
    const opt = el.options[el.selectedIndex];
    return opt ? opt.text : '-';
}

function updateSummary() {
    document.getElementById('sumZona').textContent = getCheckedLabel('zona_id');
    document.getElementById('sumArea').textContent = getSelectText('area_kerja_id');

    const jenisRadio = document.querySelector('input[name="jenis_alat_pilih"]:checked');
    document.getElementById('sumJenis').textContent = jenisRadio
        ? (jenisRadio.value === 'wheel-loader' ? 'Wheel Loader' : 'Forklift') : '-';
    document.getElementById('sumUnit').textContent = getSelectText('unit_alat_select');

    document.getElementById('sumPengawas').textContent = getSelectText('pengawas_id');
    document.getElementById('sumShift').textContent = getCheckedLabel('shift');
    document.getElementById('sumOperatorNd').textContent = getSelectText('operator_nd');
    document.getElementById('sumOperatorA').textContent = getSelectText('operator_grup_A');
    document.getElementById('sumOperatorB').textContent = getSelectText('operator_grup_B');
    document.getElementById('sumOperatorC').textContent = getSelectText('operator_grup_C');
    document.getElementById('sumOperatorD').textContent = getSelectText('operator_grup_D');

    const sumFotoGrid = document.getElementById('sumFotoGrid');
    sumFotoGrid.innerHTML = '';
    (selectedFiles || []).forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Foto ' + (idx + 1);
            sumFotoGrid.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

showStep(1);

// ==== Toggle-deselect untuk chip pilihan (klik lagi pada pilihan yang sama = batal pilih) ====
// Input radio-nya disembunyikan (pointer-events:none), jadi event harus dipasang di <label>-nya.
function makeRadioGroupToggleable(groupName, onDeselect) {
    document.querySelectorAll(`input[name="${groupName}"]`).forEach(radio => {
        const label = document.querySelector(`label[for="${radio.id}"]`);
        if (!label) return;

        label.addEventListener('mousedown', () => {
            radio.dataset.wasChecked = radio.checked ? 'true' : 'false';
        });
        label.addEventListener('touchstart', () => {
            radio.dataset.wasChecked = radio.checked ? 'true' : 'false';
        }, { passive: true });

        label.addEventListener('click', function (e) {
            if (radio.dataset.wasChecked === 'true') {
                e.preventDefault();
                radio.checked = false;
                if (onDeselect) onDeselect();
            }
        });
    });
}

makeRadioGroupToggleable('zona_id', () => {
    resetAreaChoices('-- Pilih Zona terlebih dahulu --');
    resetUnitChoices('-- Pilih Area Kerja & Jenis Alat terlebih dahulu --');
});
makeRadioGroupToggleable('jenis_alat_pilih', () => {
    resetUnitChoices('-- Pilih Area Kerja & Jenis Alat terlebih dahulu --');
});
makeRadioGroupToggleable('shift');

// ==== Choices.js init untuk dropdown dengan banyak opsi ====
const choicesConfig = {
    searchEnabled: true,
    itemSelectText: '',
    shouldSort: false,
    placeholderValue: 'Cari...',
    searchPlaceholderValue: 'Ketik untuk mencari...',
    noResultsText: 'Tidak ditemukan',
    noChoicesText: 'Tidak ada pilihan',
    position: 'bottom', // selalu buka ke bawah, jangan auto-flip ke atas
};

const areaChoices = new Choices('#area_kerja_id', { ...choicesConfig });
const unitChoices = new Choices('#unit_alat_select', { ...choicesConfig });
const pengawasChoices = new Choices('#pengawas_id', { ...choicesConfig });
const operatorChoicesMap = {};
document.querySelectorAll('.operator-select').forEach(el => {
    operatorChoicesMap[el.id] = new Choices(el, { ...choicesConfig });
});

// ==== STEP 1: Zona -> Area Kerja ====
const unitAlatIdInput = document.getElementById('unit_alat_id');

function resetAreaChoices(placeholder) {
    areaChoices.clearStore();
    areaChoices.setChoices([{ value: '', label: placeholder, selected: true, disabled: true }], 'value', 'label', true);
    areaChoices.disable();
}

function resetUnitChoices(placeholder) {
    unitChoices.clearStore();
    unitChoices.setChoices([{ value: '', label: placeholder, selected: true, disabled: true }], 'value', 'label', true);
    unitChoices.disable();
    unitAlatIdInput.value = '';
}

resetAreaChoices('-- Pilih Zona terlebih dahulu --');
resetUnitChoices('-- Pilih Area Kerja & Jenis Alat terlebih dahulu --');

document.querySelectorAll('input[name="zona_id"]').forEach(radio => {
    radio.addEventListener('change', async function () {
        resetAreaChoices('Memuat...');
        resetUnitChoices('-- Pilih Area Kerja & Jenis Alat terlebih dahulu --');

        const res = await fetch(`/ajax/area-kerja/${this.value}`);
        const data = await res.json();

        areaChoices.clearStore();
        const items = [{ value: '', label: '-- Pilih Area Kerja --', selected: true, disabled: true }]
            .concat(data.map(item => ({ value: String(item.id), label: item.nama })));
        areaChoices.setChoices(items, 'value', 'label', true);
        areaChoices.enable();
    });
});

// ==== STEP 2: Jenis alat + Area Kerja -> No Lambung ====
async function loadUnitAlatOptions() {
    const areaId = document.getElementById('area_kerja_id').value;
    const jenisRadio = document.querySelector('input[name="jenis_alat_pilih"]:checked');
    if (!areaId || !jenisRadio) return;

    resetUnitChoices('Memuat...');

    const res = await fetch(`/ajax/unit-alat/${areaId}/${jenisRadio.value}`);
    const data = await res.json();

    unitChoices.clearStore();
    const items = [{ value: '', label: '-- Pilih No. Lambung --', selected: true, disabled: true }]
        .concat(data.map(item => ({ value: String(item.id), label: item.label })));
    unitChoices.setChoices(items, 'value', 'label', true);
    if (data.length > 0) unitChoices.enable();
}

document.querySelectorAll('input[name="jenis_alat_pilih"]').forEach(r => r.addEventListener('change', loadUnitAlatOptions));
document.getElementById('area_kerja_id').addEventListener('change', loadUnitAlatOptions);

document.getElementById('unit_alat_select').addEventListener('change', async function () {
    unitAlatIdInput.value = this.value;
    if (!this.value) return;

    // sarankan (prefill) operator grup A-D sesuai roster unit yang dipilih
    const res = await fetch(`/ajax/operators/${this.value}`);
    const roster = await res.json();
    ['A', 'B', 'C', 'D'].forEach(g => {
        if (roster[g]) {
            const select = document.getElementById('operator_grup_' + g);
            select.value = roster[g].operator_id;
            operatorChoicesMap['operator_grup_' + g].setChoiceByValue(String(roster[g].operator_id));
        }
    });
});

// ==== STEP 4: multi-upload foto (bisa pilih beberapa sekaligus, bisa hapus satu-satu) ====
const dropZone = document.getElementById('dropZone');
const fotoInput = document.getElementById('fotoInput');
const photoGrid = document.getElementById('photoGrid');
let selectedFiles = [];

function syncFotoInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fotoInput.files = dt.files;
}

function renderPhotoGrid() {
    photoGrid.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.createElement('div');
            thumb.className = 'photo-thumb';
            thumb.innerHTML = `<img src="${e.target.result}" alt="Foto ${idx + 1}">
                <button type="button" class="photo-remove" data-idx="${idx}" aria-label="Hapus foto"><i class="bi bi-x"></i></button>`;
            photoGrid.appendChild(thumb);
        };
        reader.readAsDataURL(file);
    });
}

dropZone.addEventListener('click', () => fotoInput.click());

fotoInput.addEventListener('change', function () {
    selectedFiles = selectedFiles.concat(Array.from(this.files || []));
    syncFotoInputFiles();
    renderPhotoGrid();
});

photoGrid.addEventListener('click', function (e) {
    const btn = e.target.closest('.photo-remove');
    if (!btn) return;
    const idx = parseInt(btn.dataset.idx, 10);
    selectedFiles.splice(idx, 1);
    syncFotoInputFiles();
    renderPhotoGrid();
});
</script>
@endpush
