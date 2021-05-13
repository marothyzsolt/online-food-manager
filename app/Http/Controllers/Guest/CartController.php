<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    private CartService $cartService;

    /**
     * CartController constructor.
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): Response
    {
        return $this->view('guest.cart');
    }

    public function add(Request $request, Item $item): RedirectResponse
    {
        $cart = $this->cartService->getCart();
        CartItem::updateOrCreate([
            'item_id' => $item->id,
            'cart_id' => $cart->id,
        ]);

        return $this->back(true)->cookie('cart-token', $this->cartService->getCartToken());
    }

    public function delete(Request $request, Item $item): RedirectResponse
    {
        $cart = $this->getCart($request);
        $cartItem = CartItem::where([
            'item_id' => $item->id,
            'cart_id' => $cart->id,
        ]);
        if ($cartItem !== null) {
            $cartItem->delete();
        }

        return $this->back(true)->cookie('cart-token', $this->cartService->getCartToken());
    }

    public function order()
    {
        dd('order insert');
    }


}
