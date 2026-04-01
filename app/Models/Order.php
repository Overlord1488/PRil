<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'number',
        'user_id',
        'status',
        'subtotal',
        'shipping',
        'total',
        'has_digital',
        'has_physical',
        'shipping_name',
        'shipping_phone',
        'shipping_city',
        'shipping_address',
        'shipping_zip',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'subtotal' => 'decimal:2',
            'shipping' => 'decimal:2',
            'total' => 'decimal:2',
            'has_digital' => 'boolean',
            'has_physical' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }
}
