<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemWarehouse extends Pivot
{
    use HasFactory;

    protected $table = 'item_warehouse';

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }

    public function warehouse(): BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }

    public function movement(): HasMany {
        return $this->hasMany(Movement::class);
    }
}
