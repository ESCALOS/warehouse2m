<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    public function subcategory(): BelongsTo {
        return $this->belongsTo(Subcategory::class);
    }

    public function measurementUnit(): BelongsTo {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function suppliers(): BelongsToMany {
        return $this->belongsToMany(Supplier::class);
    }

    public function warehouses(): BelongsToMany {
        return $this->belongsToMany(Warehouse::class)->withPivot('quantity', 'total_cost');
    }
}
