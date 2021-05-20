<?php

namespace App\Http\Controllers\Admin\Courier;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminCourierController extends Controller
{
    public function index(): Response
    {
        $restaurants = auth()->user()->restaurants;
        $couriers = User::where('type', User::TYPE_COURIER)->get();

        return $this->view('admin.restaurants.couriers.list', compact('restaurants', 'couriers'));
    }
}
