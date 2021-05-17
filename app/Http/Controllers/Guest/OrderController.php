<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartOrderRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Cart\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(): Response
    {
        $orders = auth()->user()->orders;
dd($orders);
        return $this->view('guest.orders.list', compact('orders'));
    }

    public function show(Order $order)
    {
        return $this->view('guest.orders.show', compact('order'));
    }
}
