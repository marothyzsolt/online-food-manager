<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const TYPE_PERSONAL = 0;
    public const TYPE_DELIVERY = 1;

    public const STATUS_ORDERED = 'ordered';
    public const STATUS_MAKING = 'making';
    public const STATUS_FINISHED = 'finished';
    public const STATUS_DELIVERING = 'delivering';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_LIST = [
        self::STATUS_ORDERED,
        self::STATUS_MAKING,
        self::STATUS_FINISHED,
        self::STATUS_DELIVERING,
        self::STATUS_DELIVERED,
    ];

    public const COURIER_PENDING = 'pending';
    public const COURIER_ACCEPTED = 'accepted';
    public const COURIER_DECLINED = 'declined';
    public const COURIER_FINISHED = 'finished';
    public const COURIER_LIST = [
        self::COURIER_PENDING,
        self::COURIER_ACCEPTED,
        self::COURIER_DECLINED,
        self::COURIER_FINISHED,
    ];

    protected $fillable = [
        'name', 'zip', 'city', 'address', 'phone', 'email', 'cart_id', 'user_id', 'type', 'comment', 'status', 'token', 'restaurant_id', 'shipping_time', 'courier_id', 'courier_status'
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
            self::STATUS_MAKING => 'AZ ÉTELED KÉSZÜL...',
            self::STATUS_DELIVERING => 'FUTÁRNAK ÁTADVA, KISZÁLLÍTÁS ALATT...',
            self::STATUS_FINISHED => 'ÉTEL ELKÉSZÜLT, FUTÁRRA VÁR...',
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

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'courier_id');
    }
}
