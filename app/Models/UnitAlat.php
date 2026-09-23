<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitAlat extends Model
{
    use HasFactory;

    protected $fillable = ['unit_kerja_id', 'jenis_alat_id', 'no_lambung', 'kepemilikan', 'keterangan'];

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function jenisAlat(): BelongsTo
    {
        return $this->belongsTo(JenisAlat::class);
    }

    public function unitOperators(): HasMany
    {
        return $this->hasMany(UnitOperator::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function getLabelAttribute(): string
    {
        return trim($this->no_lambung . ' - ' . ($this->jenisAlat->nama ?? ''));
    }
}
