<?php

namespace App\Http\Controllers\Guest\Item;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    public function show(Restaurant $restaurant, Menu $menu, Item $item): Response
    {
        $item->load(['allergens', 'images']);
        $allergenList = Allergen::orderBy('name')->get();
        return $this->view('guest.items.show', compact('menu', 'restaurant', 'item', 'allergenList'));
    }
}
