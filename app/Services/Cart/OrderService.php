<?php

namespace App\Services\Cart;

use App\Http\Requests\CartOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Str;

class OrderService
{
    private Cart $cart;

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getRestaurant(): Restaurant
    {
        return $this->cart->restaurant;
    }

    public function makePersonalOrder(array $data, ?User $user): Order
    {
        return Order::create($data + [
                'token' => md5(Str::random() . time()),
                'type' => Order::TYPE_PERSONAL,
                'user_id'  => $user?->id,
                'cart_id'  => $this->cart->id,
                'restaurant_id' => $this->getRestaurant()->id,
                'shipping_time' => $this->calculateShippingTime(0),
            ]);
    }

    public function makeDeliveryOrder(array $data, ?User $user): Order
    {
        return Order::create($data + [
                'token' => md5(Str::random() . time()),
                'type' => Order::TYPE_DELIVERY,
                'user_id'  => $user?->id,
                'cart_id'  => $this->cart->id,
                'restaurant_id' => $this->getRestaurant()->id,
                'shipping_time' => $this->calculateShippingTime(15),
            ]);
    }

    public function insertCartItemsToOrder(Order $order): void
    {
        foreach ($this->cart->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->item->id,
                'price' => $item->item->endPrice(),
                'quantity' => $item->quantity,
            ]);
        }
    }

    public function finishCart(): void
    {
        $this->cart->update([
            'token' => md5(Str::random() . time()),
            'user_id' => null,
        ]);
        $this->cart->save();
    }

    private function calculateShippingTime(int $baseMinutes): int
    {
        $minutes = $baseMinutes;

        // Elkészítési idő szorzó
        foreach (Order::where('status', Order::STATUS_ORDERED)->get() as $item) {
            $minutes += ($item->items()->count() * 2);
        }

        // Kiszállítási idő szorzó
        if ($baseMinutes > 10) {
            $minutes += Order::where('status', Order::STATUS_DELIVERING)->orWhere('status', Order::STATUS_ORDERED)->count() * 5;
        }

        foreach ($this->cart->cartItems as $cartItem) {
            $minutes += $cartItem->item->make_time ?? 10;
        }

        return $minutes;
    }
}