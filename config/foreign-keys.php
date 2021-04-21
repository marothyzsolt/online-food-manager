<?php

/**
 * Foreign key list
 * table_name =>
 *   [
 *      'foreign_key' => Model::class,
 *      ...
 *   ]
 */

use App\Models\Allergen;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;

return [
    'item_menu' => [
        'menu_id' => Menu::class,
        'item_id' => Item::class,
    ],
    'category_item' => [
        'category_id' => Category::class,
        'item_id' => Item::class,
    ],
    'menu_restaurant' => [
        'restaurant_id' => Category::class,
        'menu_id' => Menu::class,
    ],
    'allergen_item' => [
        'allergen_id' => Allergen::class,
        'item_id' => Item::class,
    ],
    'item_prices' => [
        'currency_id' => Currency::class,
        'item_id' => Item::class,
    ],
    'menus' => [
        'media_id' => Media::class,
        'restaurant_id' => Restaurant::class,
    ],
    'opening_hours' => [
        'restaurant_id' => Restaurant::class,
    ],
    'restaurants' => [
        'user_id' => User::class,
    ],
    'item_media' => [
        'item_id' => Item::class,
        'media_id' => Media::class,
    ],
];
