<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{
    use HasFactory, SoftDeletes;

    public function ingresos(): HasMany {
        return $this->hasMany(CostCenterIncome::class);
    }

    public function movements(): HasMany {
        return $this->hasMany(EmployeeMovement::class);
    }
}
