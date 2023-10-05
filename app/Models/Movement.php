<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
    use HasFactory, SoftDeletes;

    public function movementDetails(): HasMany {
        return $this->hasMany(MovementDetail::class);
    }

    public function employee(): HasOne {
        return $this->hasOne(EmployeeMovement::class);
    }

    public function supplier(): HasOne {
        return $this->hasOne(Supplier::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function transfer(): BelongsTo {
        return $this->belongsTo(Transfer::class);
    }
}
