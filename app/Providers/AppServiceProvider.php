<?php

namespace App\Providers;

use App\Models\Currency;
use App\Services\Item\ItemService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ItemService::class, function () {
            return new ItemService(Currency::where('code', config('app.main_currency'))->first());
        });
    }
}
