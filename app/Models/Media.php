<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use URL;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hash', 'size', 'mime_type'];

    public const MIME_TYPE_JPG = 'image/jpeg';
    public const MIME_TYPE_PNG = 'image/png';

    public function getLinkAttribute(): string
    {
        if ($this->name === null) {
            return URL::to('/assets/404.png');
        }
        return URL::to('/storage/images/' . $this->name);
    }
}
