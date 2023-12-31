<?php

namespace App\Models;

use App\Enums\MovementTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['movement_type','movement_reason_id','user_id','warehouse_id','observations'];

    protected $casts = ['movement_type' => MovementTypeEnum::class];

    public function movementDetails(): HasMany {
        return $this->hasMany(MovementDetail::class)->withTrashed();
    }

    public function employeeMovement(): HasOne {
        return $this->hasOne(EmployeeMovement::class);
    }

    public function supplierMovement(): HasOne {
        return $this->hasOne(SupplierMovement::class);
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

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(Item::class,MovementDetail::class,'movement_id','id','id','item_warehouse_id');
    }
}
