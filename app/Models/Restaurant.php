<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'style', 'token', 'media_id'
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function items()
    {
        return $this->menus();
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
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
}
