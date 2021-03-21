<?php

/**
 * Foreign key list
 * table_name =>
 *   [
 *      'foreign_key' => Model::class,
 *      ...
 *   ]
 */

return [
    'menu_item' => [
        'menu_id' => \App\Models\Menu::class,
        'item_id' => \App\Models\Item::class,
    ],
    'category_item' => [
        'category_id' => \App\Models\Category::class,
        'item_id' => \App\Models\Item::class,
    ],
    'menu_restaurant' => [
        'restaurant_id' => \App\Models\Category::class,
        'menu_id' => \App\Models\Menu::class,
    ],
    'allergen_item' => [
        'allergen_id' => \App\Models\Allergen::class,
        'item_id' => \App\Models\Item::class,
    ],
    'item_prices' => [
        'currency_id' => \App\Models\Currency::class,
        'item_id' => \App\Models\Item::class,
    ],
    'menus' => [
        'media_id' => \App\Models\Media::class,
    ],
    'opening_hours' => [
        'restaurant_id' => \App\Models\Restaurant::class,
    ],
];
