<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'style', 'token'
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function items()
    {
        return $this->menus();
    }
}
