<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const TYPE_PERSONAL = 0;
    public const TYPE_DELIVERY = 1;

    public const STATUS_ORDERED = 'ordered';
    public const STATUS_DELIVERING = 'delivering';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_LIST = [
        self::STATUS_ORDERED,
        self::STATUS_DELIVERING,
        self::STATUS_DELIVERED,
    ];

    protected $fillable = [
        'name', 'zip', 'city', 'address', 'phone', 'email', 'cart_id', 'user_id', 'type', 'comment', 'status', 'token', 'restaurant_id', 'shipping_time'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->price;
        }

        return $total;
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ORDERED => 'RENDELÉS LEADVA',
            self::STATUS_DELIVERING => 'KISZÁLLÍTÁS FOLYAMATBAN',
            self::STATUS_DELIVERED => 'RENDELÉS TELJESÍTVE',
        };
    }

    public function getArrivedAtAttribute(): Carbon
    {
        return $this->created_at->addMinutes($this->shipping_time);
    }

    public function getArrivedAtTextAttribute(): string
    {
        if ($this->arrivedAt < now()) {
            return 'pár perc';
        }
        return $this->arrivedAt->diff(now())->format('%h óra és %i perc');
    }
}
