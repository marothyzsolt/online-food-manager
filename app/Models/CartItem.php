<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'cart_id',
        'quantity',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->item->endPrice() * $this->quantity;
    }

    public function getQuantityAttribute(?int $value): int
    {
        return (int) $value <= 0 ? 1 : (int) $value;
    }

    public function getCurrencyAttribute(): string
    {
        return $this->item->mainPrice->currency->symbol;
    }
}
