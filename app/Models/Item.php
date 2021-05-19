<?php

namespace App\Models;

use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'make_time', 'restaurant_id', 'available_from', 'available_to'
    ];

    public function itemPrices(): HasMany
    {
        return $this->hasMany(ItemPrice::class);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class);
    }

    public function mainImage(): Media
    {
        return $this->images[0] ?? new Media();
    }

    public function isAvailable(): bool
    {
        $from = true;
        $to = true;

        if ($this->available_from) {
            $from = now() > Carbon::make($this->available_from);
        }
        if ($this->available_to) {
            $to = now() < Carbon::make($this->available_to);
        }

        return $from && $to;
    }

    /**
     * @return ItemPrice|Model
     */
    public function getMainPriceAttribute(): ItemPrice
    {
        $itemPrice = $this->itemPrices()->whereHas('currency', function ($q) {
            return $q->where('code', config('app.main_currency'));
        })->first();

        return $itemPrice === null ? new ItemPrice() : $itemPrice;
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

    public function getSkuAttribute(): string
    {
        return Str::upper(Str::substr(md5($this->restaurant_id), 0, 4) . $this->id);
    }

    public function isAllergenable(Allergen $allergen): bool
    {
        return $this->allergens->has($allergen->id);
    }

    public function getLinkAttribute(): string
    {
        if ($this->menus === null) {
            return '';
        }
        return '/restaurants/' . $this->restaurant->slug . '/menus/' . $this->menus[0]->id . '/items/' . $this->id;
    }

    public function isActive(): bool
    {
        return $this->menus !== null;
    }

    public function getAllergenListAttribute(): Collection
    {
        return $this->allergens()->pluck('allergens.id') ?? collect();
    }

    public function hasAllergen(Allergen $allergen)
    {
        return $this->allergens()->where('allergens.id', $allergen->id)->count() > 0;
    }
}
