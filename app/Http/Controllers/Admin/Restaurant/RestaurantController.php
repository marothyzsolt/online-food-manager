<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;
use App\Http\Requests\Restaurant\StoreRestaurantRequest;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function __construct(private RestaurantService $restaurantService)
    {
    }

    public function index(): Response
    {
        $restaurants = auth()->user()->restaurants;

        return $this->view('admin.restaurants.list', compact('restaurants'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->restaurantService->update($restaurant, $request->all(), $request->get('days'));
        if ($request->hasFile('media')) {
            $this->restaurantService->saveImage($restaurant, $request->file('media'));
        }

        return redirect()->back()->withSuccess(['status' => true, 'data' => ['restaurant' => $restaurant]]);
    }

    public function store(StoreRestaurantRequest $request): RedirectResponse
    {
        $restaurant = Restaurant::create($request->validated() + ['token' => \Str::random(32), 'user_id' => auth()->user()->id, 'slug' => Str::slug($request->get('name'))]);
        $this->restaurantService->saveOpeningHours($restaurant, $request->get('days'));
        if ($request->hasFile('media')) {
            $this->restaurantService->saveImage($restaurant, $request->file('media'));
        }

        return redirect()->to('/admin/restaurants')->withSuccess(['status' => true, 'data' => ['restaurant' => $restaurant]]);
    }

    public function edit(Restaurant $restaurant): Response
    {
        return $this->view('admin.restaurants.edit', compact('restaurant'));
    }

    public function create(): Response
    {
        return $this->view('admin.restaurants.create');
    }
}
