<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaKerja extends Model
{
    use HasFactory;

    protected $fillable = ['zona_id', 'nama'];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    public function unitKerjas(): HasMany
    {
        return $this->hasMany(UnitKerja::class);
    }
}
