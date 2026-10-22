<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'merchant_id',
        'customer_id',
        'invoice_number',
        'delivery_date',
        'delivery_time',
        'delivery_address',
        'status',
        'total',
        'notes',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('invoice', function (Builder $invoice) use ($search) {
                        $invoice->where(
                            'invoice_number',
                            'like',
                            "%{$search}%"
                        );
                    })
                    ->orWhereHas('customer', function (Builder $customer) use ($search) {
                        $customer->where('company_name', 'like', "%{$search}%");
                    });
            });
        });
    }
}
