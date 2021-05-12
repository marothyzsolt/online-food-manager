<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\StoreRestaurantMenuRequest;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Menu\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class MenuRestaurantController extends Controller
{
    public function __construct(private MenuService $menuService)
    {
    }

    public function index(Restaurant $restaurant): Response
    {
        $restaurant->load(['menus.media', 'menus.items']);
        $menus = $restaurant->menus;

        return $this->view('admin.restaurants.menus.list', compact('menus', 'restaurant'));
    }

    public function store(StoreRestaurantMenuRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->menuService->store(
            $restaurant,
            $request->get('name'),
            $request->get('description'),
            $request->file('media')
        );

        return $this->back(true);
    }

    public function edit(Restaurant $restaurant, Menu $menu): Response
    {
        return $this->view('admin.restaurants.menus.edit', compact('restaurant', 'menu'));
    }

    public function update(StoreRestaurantMenuRequest $request, Restaurant $restaurant, Menu $menu): RedirectResponse
    {
        $this->menuService->update(
            $menu,
            $request->get('name'),
            $request->get('description'),
            $request->file('media')
        );

        return $this->back(true, ['menu' => $menu]);
    }

    public function destroy(Restaurant $restaurant, Menu $menu): RedirectResponse
    {
        $menu->delete();

        return $this->back(true);
    }
}
