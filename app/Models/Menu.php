<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'slug',
        'description',
        'photo',
        'price',
        'is_available',
    ];


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
