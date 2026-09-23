<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'no_hp'];

    public function unitOperators(): HasMany
    {
        return $this->hasMany(UnitOperator::class);
    }
}
