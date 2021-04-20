<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function itemPrice(): HasOne
    {
        return $this->hasOne(ItemPrice::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }
}
