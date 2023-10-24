<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'document_type', 'document_number'];

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class);
    }

    public function movements(): HasMany {
        return $this->hasMany(EmployeeMovement::class);
    }
}
