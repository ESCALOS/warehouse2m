<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function setDocumentTypeAtttribute($value): void {
        if(!in_array($value, ['DNI', 'CE'])) {
            throw new \InvalidArgumentException("Tipo de documento no válido");
        }
        $this->attributes['document_type'] = $value;
    }

    public function area(): BelongsTo {
        return $this->belongsTo(Area::class);
    }
}
