<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function itemPrices(): HasMany
    {
        return $this->hasMany(ItemPrice::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }

    public function mainPrice(): HasMany
    {
        return $this->itemPrices()->whereHas('currency', function ($q) {
            return $q->where('code', config('app.main_currency'));
        });
    }
}
