<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();
        Restaurant::query()->truncate();
        Menu::query()->truncate();
        Currency::query()->truncate();

        $this->call([
            UserSeeder::class,
            RestaurantSeeder::class,
            CurrencySeeder::class,
            MenuSeeder::class,
        ]);

        User::factory()->count(10)->create();
    }
}
