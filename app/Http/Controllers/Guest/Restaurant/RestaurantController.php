<?php

namespace App\Http\Controllers\Guest\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    public function index(): Response
    {
        $restaurants = Restaurant::all();

        return $this->view('guest.restaurants.list', compact('restaurants'));
    }

    public function show(Restaurant $restaurant): Response
    {
        return $this->view('guest.restaurants.show', compact('restaurant'));
    }
}
