<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['movement_detail_id','quantity','expiry_date'];

    public function movementDetail() {
        return $this->belongsTo(MovementDetail::class);
    }
}
