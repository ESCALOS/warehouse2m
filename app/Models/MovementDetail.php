<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovementDetail extends Model
{
    use HasFactory, SoftDeletes;

    public function movement(): BelongsTo {
        return $this->belongsTo(Movement::class);
    }

    public function batch(): hasMany {
        return $this->hasMany(Batch::class);
    }
}
