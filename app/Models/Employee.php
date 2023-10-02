<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function setDocumentTypeAtttribute($value) {
        if(!in_array($value, ['DNI', 'CE'])) {
            throw new \InvalidArgumentException("Tipo de documento no válido");
        }
        $this->attributes['document_type'] = $value;
    }

    public function area() {
        return $this->belongsTo(Area::class);
    }
}
