<?php

namespace App\Models;

use App\Enums\MovementTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovementReason extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['movement_type', 'description'];

    protected $casts = ['movement_type' => MovementTypeEnum::class];

    public function stockMovements(): HasMany {
        return $this->hasMany(StockMovement::class);
    }
}
