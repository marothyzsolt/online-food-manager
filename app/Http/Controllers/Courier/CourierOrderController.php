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
            $q->where('orders.courier_status', Order::COURIER_PENDING)->where('orders.type', Order::TYPE_DELIVERY)->where('orders.status', Order::STATUS_FINISHED);
        })->get();
        $acceptedOrders = Order::where(['courier_id' => $user->id])->where('orders.courier_status', Order::COURIER_ACCEPTED)->get();
        $finishedOrders = Order::where(['courier_id' => $user->id])->where('orders.courier_status', Order::COURIER_FINISHED)->get();

        $balance = 0;
        foreach ($finishedOrders as $order) {
            if ($user->commission > 0 && $user->commission < 100) {
                $balance += $order->total / $user->commission / 100;
            }
        }

        $stat = [
            'finished_orders' => count($finishedOrders) ?? 0,
            'balance' => $balance ?? 0,
            'commission' => $user->commission ?? 0,
        ];

        return $this->view('courier.orders.list', compact('pendingOrders', 'acceptedOrders', 'stat', 'user'));
    }

    public function accept(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_ACCEPTED, 'status' => Order::STATUS_DELIVERING, 'courier_id' => auth()->user()->id]);

        return $this->back(true, ['message' => 'Sikeres megrendelés elfogadás']);
    }

    public function decline(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_DECLINED]);

        return $this->back(true, ['message' => 'Megrendelés elutasítva']);
    }

    public function finished(Order $order): RedirectResponse
    {
        $order->update(['courier_status' => Order::COURIER_FINISHED, 'status' => Order::STATUS_DELIVERED]);

        return $this->back(true, ['message' => 'Megrendelés lezárva, étel átadva']);
    }
}
