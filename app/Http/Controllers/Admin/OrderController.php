<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $orders = Order::whereIn('restaurant_id', $user->restaurants->pluck('id'))->get();

        return $this->view('admin.orders', compact('orders', 'user'));
    }
}
