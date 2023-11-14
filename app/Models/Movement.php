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

    protected $fillable = ['movement_type','movement_reason_id','user_id','warehouse_id'];

    public function movementDetails(): HasMany {
        return $this->hasMany(MovementDetail::class);
    }

    public function employeeMovement(): HasOne {
        return $this->hasOne(EmployeeMovement::class);
    }

    public function supplier(): HasOne {
        return $this->hasOne(Supplier::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function warehouse(): BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }

    public function movementReason(): BelongsTo {
        return $this->belongsTo(MovementReason::class);
    }

    public function transfer(): BelongsTo {
        return $this->belongsTo(Transfer::class);
    }
}
