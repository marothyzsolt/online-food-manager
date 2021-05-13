<?php

use App\Http\Controllers\Admin\Item\ItemController;
use App\Http\Controllers\Admin\Restaurant\MenuRestaurantController;
use App\Http\Controllers\Admin\Restaurant\RestaurantController;
use App\Http\Controllers\Guest\CartController;
use App\Http\Controllers\Guest\MenuController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/restaurants', \App\Http\Controllers\Guest\Restaurant\RestaurantController::class)->parameters([
    'restaurants' => 'restaurant:slug',
]);
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['user.check:admin', 'auth']], function() {
    Route::resource('/restaurants', RestaurantController::class)->parameters([
        'restaurants' => 'restaurant:slug',
    ]);

    Route::resource('/restaurants/{restaurant:slug}/menus', MenuRestaurantController::class);
    Route::resource('/restaurants/{restaurant:slug}/menus/{menu}/items', \App\Http\Controllers\Admin\Item\MenuItemController::class);
});

Route::get('/restaurants/{restaurant:slug}/menus/{menu}', [MenuController::class, 'show']);

//Route::resource('/restaurants/{restaurant:slug}/menus/{menu}/items', MenuItemController::class);
Route::resource('/restaurants/{restaurant:slug}/items', ItemController::class);

Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/add/{item}', [CartController::class, 'add']);
Route::get('/cart/delete/{item}', [CartController::class, 'delete']);
Route::post('/cart', [CartController::class, 'order']);