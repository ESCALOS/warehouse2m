<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenterIncome extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['amount'];

    public function costCenter(): BelongsTo {
        return $this->belongsTo(CostCenter::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
