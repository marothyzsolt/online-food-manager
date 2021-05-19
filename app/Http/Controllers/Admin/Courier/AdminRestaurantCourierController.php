<?php

namespace App\Http\Controllers\Admin\Courier;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminRestaurantCourierController extends Controller
{
    public function destroy(Restaurant $restaurant, User $user): RedirectResponse
    {
        $restaurant->couriers()->detach($user);

        return $this->back(true);
    }

    public function store(Request $request, Restaurant $restaurant): RedirectResponse
    {
        $courier = User::find($request->get('courier'));
        $restaurant->couriers()->syncWithoutDetaching([$courier->id]);

        return $this->back(true);
    }
}
