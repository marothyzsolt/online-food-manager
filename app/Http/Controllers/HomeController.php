<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $restaurants = Restaurant::all();
        $items = Item::all()->shuffle()->splice(0, 6);
        $menus = Menu::all()->shuffle()->splice(0, 6);

        return $this->view(
            'home.index',
            compact('restaurants', 'items', 'menus')
        );
    }
}
