<?php

use App\Http\Controllers\Admin\Item\ItemController;
use App\Http\Controllers\Admin\Restaurant\MenuRestaurantController;
use App\Http\Controllers\Admin\Restaurant\RestaurantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Restaurant\MenuItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::resource('/restaurants', RestaurantController::class)->parameters([
    'restaurants' => 'restaurant:slug',
]);
Route::resource('/restaurants/{restaurant:slug}/menus', MenuRestaurantController::class);

//Route::resource('/restaurants/{restaurant:slug}/menus/{menu}/items', MenuItemController::class);
Route::resource('/restaurants/{restaurant:slug}/items', ItemController::class);