<?php

use App\Http\Controllers\Admin\Courier\AdminCourierController;
use App\Http\Controllers\Admin\Courier\AdminRestaurantCourierController;
use App\Http\Controllers\Admin\Item\ItemController;
use App\Http\Controllers\Admin\Item\MenuItemController;
use App\Http\Controllers\Admin\Restaurant\MenuRestaurantController;
use App\Http\Controllers\Admin\Restaurant\RestaurantController;
use App\Http\Controllers\Admin\Restaurant\RestaurantItemController;
use App\Http\Controllers\Courier\CourierOrderController;
use App\Http\Controllers\Guest\CartController;
use App\Http\Controllers\Guest\MenuController;
use App\Http\Controllers\Guest\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/restaurants', \App\Http\Controllers\Guest\Restaurant\RestaurantController::class)->parameters([
    'restaurants' => 'restaurant:slug',
]);
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['user.check:admin', 'auth']], function() {
    Route::resource('/restaurants', RestaurantController::class)->parameters([
        'restaurants' => 'restaurant:slug',
    ]);

    Route::resource('/restaurants/{restaurant:slug}/items', RestaurantItemController::class);
    Route::get('/restaurants/{restaurant:slug}/items/{item}/images/{hash}/delete', [RestaurantItemController::class, 'deleteImage']);
    Route::resource('/restaurants/{restaurant:slug}/menus', MenuRestaurantController::class);
    Route::resource('/restaurants/{restaurant:slug}/menus/{menu}/items', MenuItemController::class);

    Route::resource('/restaurants/{restaurant:slug}/couriers', AdminRestaurantCourierController::class)->parameters([
        'couriers' => 'user:id',
    ]);
    Route::resource('/couriers', AdminCourierController::class)->parameters([
        'couriers' => 'user:id',
    ]);
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::group(['prefix' => '/courier', 'as' => 'admin.', 'middleware' => ['user.check:courier', 'auth']], function() {
        Route::get('/orders', [CourierOrderController::class, 'index']);
        Route::get('/orders/{order}/accept', [CourierOrderController::class, 'accept']);
        Route::get('/orders/{order}/decline', [CourierOrderController::class, 'decline']);
        Route::get('/orders/{order}/finished', [CourierOrderController::class, 'decline']);
    });
});

Route::get('/restaurants/{restaurant:slug}/menus/{menu}', [MenuController::class, 'show']);

Route::resource('/restaurants/{restaurant:slug}/menus/{menu}/items', \App\Http\Controllers\Guest\Item\MenuItemController::class);
Route::resource('/restaurants/{restaurant:slug}/items', ItemController::class);

Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/add/{item}', [CartController::class, 'add']);
Route::get('/cart/delete/{item}', [CartController::class, 'delete']);
Route::post('/cart', [CartController::class, 'order']);

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order:token}', [OrderController::class, 'show']);