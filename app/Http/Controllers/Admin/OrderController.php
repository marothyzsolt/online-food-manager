<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $fromString = $request->get('from', '') ?? '';
        $toString = $request->get('to', '') ?? '';

        $orders = Order::whereIn('restaurant_id', $user->restaurants->pluck('id'));
        if (strlen($fromString) > 0) {
            $orders->where('created_at', '>', $fromString);
        }
        if (strlen($toString) > 0) {
            $orders->where('created_at', '<', $toString);
        }

        $orders = $orders->get();

        return $this->view('admin.orders', compact('orders', 'user', 'fromString', 'toString'));
    }

    public function statusMaking(Order $order)
    {
        $order->update(['status' => Order::STATUS_MAKING]);

        return $this->back(true);
    }

    public function statusFinished(Order $order)
    {
        $order->update(['status' => Order::STATUS_FINISHED]);

        return $this->back(true);
    }

    public function statusDelivered(Order $order)
    {
        $order->update(['status' => Order::STATUS_DELIVERED]);

        return $this->back(true);
    }

    public function statusRefresh(Order $order)
    {
        $order->update(['courier_status' => Order::COURIER_PENDING]);

        return $this->back(true);
    }
}
