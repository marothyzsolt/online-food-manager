<?php

namespace App\Models;

use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'make_time', 'restaurant_id'
    ];

    public function itemPrices(): HasMany
    {
        return $this->hasMany(ItemPrice::class);
    }

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }

    public function mainImage(): Media
    {
        return $this->images[0] ?? new Media();
    }

    /**
     * @return ItemPrice|Model
     */
    public function getMainPriceAttribute(): ItemPrice
    {
        return $this->itemPrices()->whereHas('currency', function ($q) {
            return $q->where('code', config('app.main_currency'));
        })->first();
    }

    public function getDiscountedAttribute(): bool
    {
        return $this->mainPrice->discount_type !== null;
    }

    public function endPrice(): float
    {
        if ($this->discounted) {
            return $this->mainPrice->discountedPrice;
        }
        return $this->mainPrice->price;
    }
}
