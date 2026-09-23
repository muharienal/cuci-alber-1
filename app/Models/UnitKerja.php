<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitKerja extends Model
{
    use HasFactory;

    protected $fillable = ['area_kerja_id', 'nama'];

    public function areaKerja(): BelongsTo
    {
        return $this->belongsTo(AreaKerja::class);
    }

    public function unitAlats(): HasMany
    {
        return $this->hasMany(UnitAlat::class);
    }
}
