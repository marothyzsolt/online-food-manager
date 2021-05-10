<?php

namespace App\Http\Composers;

use App\Models\User;
use App\Services\Cart\CartService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class UserComposer
{
    private CartService $cartService;

    /**
     * CartController constructor.
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function compose(View $view)
    {
        if (! request()->route()) {
            return null;
        }

        $cart = $this->cartService->getCart();
        /** @var User $user */
        $user = auth()->user();
        Cookie::queue('cart-token', $this->cartService->getCartToken(), 60000);

        $view->with('cart', (object) [
            'count' => $cart->cartItems()->count(),
            'total' => $cart->total,
            'items' => $cart->cartItems,
            'service' => $this->cartService,
            'cart' => $cart,
            'role' => $user?->type
        ]);
    }
}