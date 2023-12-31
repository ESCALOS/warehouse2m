<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['description','category_id'];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }
}
