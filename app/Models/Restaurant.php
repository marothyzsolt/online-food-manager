<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'style', 'token', 'media_id', 'address', 'phone', 'email', 'user_id', 'slug'
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class)->withDefault();
    }

    public function getDeliveryTimeAttribute(?int $value)
    {
        if ($value < 1) {
            return 30;
        }

        return $value;
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function getOpeningHourListAttribute(): iterable
    {
        $timetable = [];

        for ($i = 0; $i < 7; $i++) {
            $timetable[$i] = $this->openingHours()->where('day', $i)->first() ?? null;
        }

        return $timetable;
    }

    public function getLinkAttribute()
    {
        return '/restaurants/' . $this->slug;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isOpen(): bool
    {
        if (empty($this->openingHourList[now()->weekday()])) {
            return false;
        }
        if (($openingHour = $this->openingHourList[now()->weekday() - 1]) === null) {
            return false;
        }

        return now()->hour > $openingHour->from && now()->hour < $openingHour->to;
    }

    public function isClosed(): bool
    {
        return ! $this->isOpen();
    }
}
