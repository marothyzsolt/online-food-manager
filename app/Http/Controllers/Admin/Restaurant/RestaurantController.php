<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;
use App\Http\Requests\Restaurant\StoreRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    public function index(): Response
    {
        $restaurants = Restaurant::where('user_id', auth()->user()->id)->all();
        dd($restaurants);

        return $this->view('admin.restaurants.list', compact('restaurants'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): Response
    {
        $restaurant->update($request->all());

        return redirect()->back()->withSuccess(['status' => true, 'data' => ['restaurant' => $restaurant]]);
    }

    public function store(StoreRestaurantRequest $request): Response
    {
        $restaurant = Restaurant::create($request->validated() + ['token' => \Str::random(32)]);

        return redirect()->back()->withSuccess(['status' => true, 'data' => ['restaurant' => $restaurant]]);
    }

    public function edit(Restaurant $restaurant): Response
    {
        return $this->view('admin.restaurants.edit', compact('restaurant'));
    }
}
