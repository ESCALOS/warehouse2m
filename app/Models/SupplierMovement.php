<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierMovement extends Model
{
    protected $fillable = ['movement_id', 'supplier_id'];

    use HasFactory;

    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class);
    }

    public function movement(): BelongsTo {
        return $this->belongsTo(Movement::class);
    }
}
