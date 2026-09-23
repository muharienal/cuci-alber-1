<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitOperator extends Model
{
    use HasFactory;

    protected $fillable = ['unit_alat_id', 'operator_id', 'grup'];

    public function unitAlat(): BelongsTo
    {
        return $this->belongsTo(UnitAlat::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }
}
