<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use URL;

class Media extends Model
{
    use HasFactory;

    public const MIME_TYPE_JPG = 'image/jpeg';
    public const MIME_TYPE_PNG = 'image/png';

    public function getLinkAttribute(): string
    {
        return URL::to('/storage/images/' . $this->name);
    }
}
