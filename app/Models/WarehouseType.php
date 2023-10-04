<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseType extends Model
{
    use HasFactory, SoftDeletes;

    public function warehouses(): HasMany {
        return $this->hasMany(Warehouse::class);
    }
}
