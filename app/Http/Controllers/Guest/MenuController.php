<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    public function show(Restaurant $restaurant, Menu $menu): Response
    {
        return $this->view('guest.restaurants.menus.show', compact('menu', 'restaurant'));
    }
}
