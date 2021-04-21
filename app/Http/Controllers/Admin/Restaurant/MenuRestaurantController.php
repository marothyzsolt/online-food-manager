<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\StoreRestaurantMenuRequest;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Media\MenuService;
use Illuminate\Http\Response;

class MenuRestaurantController extends Controller
{
    public function __construct(private MenuService $menuService)
    {
    }

    public function index(Restaurant $restaurant): Response
    {
        $restaurant->load(['menus.media']);
    }

    public function create(): Response
    {
        return $this->view('admin.restaurants.menus.create');
    }

    public function store(StoreRestaurantMenuRequest $request, Restaurant $restaurant): Response
    {
        $this->menuService->store(
            $restaurant,
            $request->get('name'),
            $request->get('description'),
            $request->get('image')
        );

        return $this->back(true, ['menu' => $menu]);
    }

    public function edit(Menu $menu): Response
    {
        return $this->view('admin.restaurants.menus.edit');
    }

    public function update(StoreRestaurantMenuRequest $request, Menu $menu): Response
    {
        $this->menuService->update(
            $menu,
            $request->get('name'),
            $request->get('description'),
            $request->get('image')
        );

        return $this->back(true, ['menu' => $menu]);
    }

    public function destroy(Menu $menu): Response
    {
        $menu->delete();

        return $this->back(true);
    }
}
