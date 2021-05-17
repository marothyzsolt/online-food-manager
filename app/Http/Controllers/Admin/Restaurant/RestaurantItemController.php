<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRestaurantItemRequest;
use App\Models\Item;
use App\Models\Media;
use App\Models\Restaurant;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class RestaurantItemController extends Controller
{
    public function __construct(private RestaurantService $restaurantService)
    {
    }

    public function index(Restaurant $restaurant): Response
    {
        $items = $restaurant->items;

        return $this->view('admin.items.list', compact('items', 'restaurant'));
    }

    public function edit(Restaurant $restaurant, Item $item): Response
    {
        return $this->view('admin.items.edit', compact('item', 'restaurant'));
    }

    public function update(UpdateRestaurantItemRequest $request, Restaurant $restaurant, Item $item): RedirectResponse
    {
        $this->restaurantService->updateItem($restaurant, $item, $request);

        return $this->back(true);
    }

    public function deleteImage(Restaurant $restaurant, Item $item, $hash)
    {
        $media = $item->images()->where('media.hash', $hash)->first();
        $item->images()->detach($media);

        return $this->back(true);
    }
}
