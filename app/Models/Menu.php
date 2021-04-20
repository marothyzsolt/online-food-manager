<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'name', 'description', 'style', 'media_id'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
