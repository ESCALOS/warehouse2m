<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function measurementunit() {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function suppliers() {
        return $this->belongsToMany(Supplier::class);
    }
}
