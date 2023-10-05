<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transfer extends Model
{
    use HasFactory;

    /**
     * Muestra el movimiento de salida del almacen
     */
    public function movement(): BelongsTo {
        return $this->belongsTo(Movement::class);
    }

    /**
     * Muestra el almacen de destino
     */
    public function warehouse(): BelongsTo {
        return $this->belongsTo(Warehouse::class);
    }
}
