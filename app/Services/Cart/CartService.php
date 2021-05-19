<?php

namespace App\Services\Cart;

use App\Http\Requests\CartOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\Request;

class CartService
{
    private Request $request;
    private ?string $cartToken = null;

    /**
     * CartService constructor.
     */
    public function __construct(Request $request, private OrderService $orderService, private RestaurantService $restaurantService)
    {
        $this->request = $request;
    }

    public function getCart(): ?Cart
    {
        if (auth()->check()) {
            $user = auth()->user();

            if (! ($cart = $user->cart)) {
                $cart = Cart::updateOrCreate(['token' => $this->getCartToken()], ['user_id' => $user->id]);
            }

            return $cart;
        }

        if (! ($cart = Cart::where('token', $this->getCartToken())->first())) {
            $cart = Cart::updateOrCreate(['token' => $this->getCartToken()], ['user_id' => null]);
        }

        return $cart;
    }

    public function getCartToken(): string
    {
        if ($this->cartToken === null) {
            $this->cartToken = $this->request->cookie('cart-token') ?? uniqid();
        }

        return $this->cartToken;
    }

    public function inCart(int $id): bool
    {
        return $this->getCart()->cartItems->filter(fn($cartItem) => $cartItem->item->id === $id)->count() > 0;
    }

    public function calculateShippingTime(Cart $cart): int
    {
        if ($cart === null || $cart->restaurant === null) {
            return 0;
        }
        $otherOrders = $cart->restaurant->orders;

        //dd($otherOrders);
        $minutes = 20;

        foreach ($cart->cartItems as $item) {
            $minutes += $item->item->make_time;
        }

        return $minutes;
    }

    public function sendOrder(CartOrderRequest $request, ?User $user): Order
    {
        $this->orderService->setCart($this->getCart());

        if ($user = auth()->user()) {
            $data = [
                'name' => $user->name,
                'zip' => $user->zip,
                'city' => $user->city,
                'address' => $user->address,
                'phone' => $request->get('phone'),
                'email' => $user->email,
                'comment' => $request->get('comment'),
                'courier_status' => Order::COURIER_PENDING,
            ];
        } else {
            $data = $request->only(['name', 'zip', 'city', 'address', 'phone', 'email', 'comment']);
        }

        $data['courier_id'] = $this->restaurantService->getActiveCourier($this->getCart()->restaurant)?->id;

        dd($data);

        $order = match ((int) request()->get('type', -1)) {
            Order::TYPE_PERSONAL => $this->orderService->makePersonalOrder($data, $user),
            Order::TYPE_DELIVERY => $this->orderService->makeDeliveryOrder($data, $user),
        };

        $this->orderService->insertCartItemsToOrder($order);
        $this->orderService->finishCart();

        return $order;
    }
}