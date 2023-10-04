<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemWarehouse extends Model
{
    use HasFactory;

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }

    public function warehouse(): BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }

    public function stockMovement(): HasMany {
        return $this->hasMany(StockMovement::class);
    }
}
