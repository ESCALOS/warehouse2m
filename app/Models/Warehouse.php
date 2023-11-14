<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['description', 'warehouse_type_id'];

    public function warehouseType(): BelongsTo {
        return $this->belongsTo(WarehouseType::class);
    }

    public function responsables(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function items(): BelongsToMany {
        return $this->belongsToMany(Item::class)->withPivot('quantity', 'total_cost');
    }

    public function entryTransfers(): HasMany {
        return $this->hasMany(Transfer::class);
    }

    public function movements(): HasMany {
        return $this->hasMany(Movement::class);
    }
}
