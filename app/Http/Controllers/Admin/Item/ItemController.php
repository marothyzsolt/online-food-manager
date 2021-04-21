<?php

namespace App\Http\Controllers\Admin\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Item\ItemService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * ItemController constructor.
     */
    public function __construct(private ItemService $itemService)
    {
    }

    public function index(Restaurant $restaurant): Response
    {
        $restaurant->load(['menus.items', 'menus.items.images', 'menus.items.itemPrices']);

        $items = collect();
        foreach ($restaurant->menus as $menu) {
            foreach ($menu->items as $item) {
                $items->push($item);
            }
        }

        dump($items);
        dd($items[0]->mainPrice);

        return $this->view('admin.items.list');
    }

    public function create(): Response
    {
        return $this->view('admin.items.create');
    }

    public function store(StoreItemRequest $request): Response
    {
        $item = $this->itemService->store($request);

        return $this->back(true, ['item' => $item]);
    }

    public function edit(Item $item): Response
    {
        return $this->view('admin.items.edit', compact('item'));
    }

    public function update(StoreItemRequest $request, Item $item): Response
    {
        $item = $this->itemService->store($request, $item);

        return $this->back(true, ['item' => $item]);
    }

    public function destroy(Item $item): Response
    {
        $this->itemService->delete($item);

        return $this->back(true);
    }
}
