<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const TYPE_COURIER = 'courier';
    public const TYPE_ADMIN = 'admin';
    public const TYPE_GUEST = 'guest';

    public const TYPE_LIST = [
        self::TYPE_COURIER,
        self::TYPE_ADMIN,
        self::TYPE_GUEST,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'zip',
        'city',
        'password',
        'address',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(CourierActivity::class);
    }

    public function getActivityListAttribute(): iterable
    {
        $timetable = [];

        for ($i = 0; $i < 7; $i++) {
            $timetable[$i] = $this->activities()->where('day', $i)->first() ?? null;
        }

        return $timetable;
    }

    public function courierRestaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function courierOrders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Restaurant::class)->orWhereNull('orders.courier_id');
    }
}
