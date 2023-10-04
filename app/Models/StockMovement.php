<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use HasFactory, SoftDeletes;

    public function stock(): BelongsTo {
        return $this->belongsTo(ItemWarehouse::class);
    }

    public function movementReason(): BelongsTo {
        return $this->belongsTo(MovementReason::class);
    }
}
