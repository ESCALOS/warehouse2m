<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovementReason extends Model
{
    use HasFactory, SoftDeletes;

    public function stockMovements(): HasMany {
        return $this->hasMany(StockMovement::class);
    }
}
