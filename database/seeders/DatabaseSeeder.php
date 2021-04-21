<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use Faker\Factory;
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

        $this->call([
            UserSeeder::class,
            RestaurantSeeder::class,
            CurrencySeeder::class,
        ]);

        User::factory()->count(10)->create();
        Restaurant::factory()->count(5)->create();



        Menu::factory()->count(15)->afterCreating(function (Menu $menu) {
            $menu->items()->saveMany(Item::factory()->count(rand(1, 10))
                ->afterCreating(function (Item $item) {
                    $item->itemPrices()->saveMany([
                        ItemPrice::factory(['item_id' => $item->id])->createOne()
                    ]);
                })
                ->create());
        })->create();
    }
}
