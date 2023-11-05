<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'document_type', 'document_number','area_id'];

    protected $casts = ['document_type' => DocumentTypeEnum::class];

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class);
    }

    public function movements(): HasMany {
        return $this->hasMany(EmployeeMovement::class);
    }
}
