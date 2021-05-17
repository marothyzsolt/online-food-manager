<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemPrice extends Model
{
    use HasFactory;

    public const DISCOUNT_TYPE_PRICE = 'price';
    public const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    public const DISCOUNT_TYPE_LIST = [
        self::DISCOUNT_TYPE_PRICE,
        self::DISCOUNT_TYPE_PERCENTAGE,
    ];

    protected $fillable = [
        'item_id', 'currency_id', 'price', 'discount_type', 'discount'
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function getDiscountedPriceAttribute()
    {
        return match ($this->discount_type) {
            self::DISCOUNT_TYPE_PRICE => $this->discount,
            self::DISCOUNT_TYPE_PERCENTAGE => $this->price * ($this->discount / 100),
            default => $this->price,
        };
    }
}
