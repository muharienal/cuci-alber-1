<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_alat_id', 'pengawas_id', 'shift',
        'operator_nd_id', 'operator_grup_a_id', 'operator_grup_b_id', 'operator_grup_c_id', 'operator_grup_d_id',
        'zona_snapshot', 'area_kerja_snapshot', 'unit_kerja_snapshot', 'jenis_alat_snapshot', 'no_lambung_snapshot',
    ];

    public function unitAlat(): BelongsTo
    {
        return $this->belongsTo(UnitAlat::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(SubmissionPhoto::class);
    }

    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(Pengawas::class);
    }

    public function operatorNd(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_nd_id');
    }

    public function operatorGrupA(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_grup_a_id');
    }

    public function operatorGrupB(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_grup_b_id');
    }

    public function operatorGrupC(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_grup_c_id');
    }

    public function operatorGrupD(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'operator_grup_d_id');
    }

    /**
     * Ringkasan nama-nama operator yang mengisi (untuk ditampilkan di tabel laporan).
     */
    public function getOperatorSummaryAttribute(): string
    {
        $names = [];
        if ($this->operatorNd) $names[] = 'ND: ' . $this->operatorNd->nama;
        if ($this->operatorGrupA) $names[] = 'A: ' . $this->operatorGrupA->nama;
        if ($this->operatorGrupB) $names[] = 'B: ' . $this->operatorGrupB->nama;
        if ($this->operatorGrupC) $names[] = 'C: ' . $this->operatorGrupC->nama;
        if ($this->operatorGrupD) $names[] = 'D: ' . $this->operatorGrupD->nama;

        return $names ? implode(', ', $names) : '-';
    }
}
