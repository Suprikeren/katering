<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'icon',
        'thumbnail',
        'address',
        'location',
        'phone',
        'food_type',
        'description',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query, string $search) {
            $query->where('company_name', 'like', "%{$search}%");
        });
    }

   public function scopeFilterLocation(Builder $query, ?string $location): Builder
{
    return $query->when($location, function (Builder $query, string $location) {
        $query->where('location', $location);
    });
}

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
