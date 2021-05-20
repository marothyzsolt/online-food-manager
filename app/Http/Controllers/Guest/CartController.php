<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartOrderRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct(private CartService $cartService)
    {
    }

    public function index(): Response
    {
        return $this->view('guest.cart');
    }

    public function add(Request $request, Item $item): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if ($item->restaurant->isClosed()) {
            return $this->back(true)->cookie('cart-token', $this->cartService->getCartToken());
        }

        if ($cart->restaurant !== null && $item->restaurant->id !== $cart->restaurant->id) {
            return $this->back(false, ['cart' => 'restaurant_error'])->cookie('cart-token', $this->cartService->getCartToken());
        }

        $cart->update(['restaurant_id' => $item->restaurant->id]);
        CartItem::updateOrCreate([
            'item_id' => $item->id,
            'cart_id' => $cart->id,
        ]);

        return $this->back(true)->cookie('cart-token', $this->cartService->getCartToken());
    }

    public function delete(Request $request, Item $item): RedirectResponse
    {
        $cart = $this->cartService->getCart($request);
        $cartItem = CartItem::where([
            'item_id' => $item->id,
            'cart_id' => $cart->id,
        ]);
        if ($cartItem !== null) {
            $cartItem->delete();
        }
        if ($cart->cartItems()->count() === 0) {
            $cart->update(['restaurant_id' => null]);
        }

        return $this->back(true)->cookie('cart-token', $this->cartService->getCartToken());
    }

    public function order(CartOrderRequest $request): RedirectResponse
    {
        $order = $this->cartService->sendOrder($request, auth()->user());
        $this->cartService->getCart($request);

        return $this->to('/cart', true, ['order' => true, 'token' => $order->token])->cookie('cart-token', $this->cartService->getCartToken());
    }


}
