<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ItemPrice extends Model
{
    use HasFactory;

    public const DISCOUNT_TYPE_PRICE = 'price';
    public const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    public const DISCOUNT_TYPE_LIST = [
        self::DISCOUNT_TYPE_PRICE,
        self::DISCOUNT_TYPE_PERCENTAGE,
    ];

    protected $fillable = [
        'item_id', 'currency_id', 'price', 'discount_type', 'discount'
    ];
}