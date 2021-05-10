<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'user_id',
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute(): float
    {
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->item->endPrice() * $cartItem->quantity;
        }

        return $total;
    }
}
