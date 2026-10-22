<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Menu extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'photo',
        'price',
        'is_available',
    ];

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
            ->orWhere('name');
        });
    }


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
