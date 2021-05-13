<?php

namespace App\Services\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartService
{
    private Request $request;
    private ?string $cartToken = null;

    /**
     * CartService constructor.
     */
    public function __construct(Request $request)
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
        $minutes = 0;

        foreach ($cart->cartItems as $item) {
            $minutes += $item->item->make_time;
        }

        return $minutes;
    }
}