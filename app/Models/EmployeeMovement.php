<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeMovement extends Model
{
    use HasFactory;

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function movement() :BelongsTo {
        return $this->belongsTo(Movement::class);
    }

    public function costCenter(): BelongsTo {
        return $this->belongsTo(CostCenter::class);
    }
}
