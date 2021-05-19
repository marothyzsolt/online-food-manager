<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourierOrderController extends Controller
{
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();
        $pendingOrders = $user->courierOrders()->where(function ($q) {
            $q->where('orders.courier_status', Order::COURIER_PENDING);
        })->get();
        $acceptedOrders = $user->courierOrders()->where('orders.courier_status', Order::COURIER_ACCEPTED)->get();
        $finishedOrdersCount = $user->courierOrders()->where('orders.courier_status', Order::COURIER_FINISHED)->count();
        $stat = [
            'finished_orders' => $finishedOrdersCount ?? 0,
            'balance' => $user->balance ?? 0,
            'commission' => $user->commission ?? 0,
        ];

        return $this->view('courier.orders.list', compact('pendingOrders', 'acceptedOrders', 'stat', 'user'));
    }

    public function accept(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_ACCEPTED]);

        return $this->back(true, ['message' => 'Sikeres megrendelés elfogadás']);
    }

    public function decline(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_DECLINED]);

        return $this->back(true, ['message' => 'Megrendelés elutasítva']);
    }

    public function finished(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_FINISHED, 'courier_id' => null]);

        return $this->back(true, ['message' => 'Megrendelés elutasítva']);
    }
}
