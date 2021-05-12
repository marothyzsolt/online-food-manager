<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\Media;
use App\Models\Menu;
use App\Services\Media\MediaHandler;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    private Generator $faker;

    /**
     * MenuSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = app()->make(Generator::class);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Storage::disk('public')->makeDirectory('images');
        /** @var MediaHandler $mediaHandler */
        $mediaHandler = app()->make(MediaHandler::class);

        Menu::factory()->count(15)->afterCreating(function (Menu $menu) use ($mediaHandler) {
            $menu->items()->saveMany(Item::factory(['restaurant_id' => $menu->restaurant->id])->count(rand(1, 5))
                ->afterCreating(function (Item $item) use ($mediaHandler) {
                    $imagePath = $this->faker->randomImage('images', '', 640, 480, 'food,eat,meal');
                    $mediaHandler->setDisk('images');
                    $media = $mediaHandler->makeMedia($imagePath, Media::MIME_TYPE_PNG);

                    $item->images()->saveMany([
                        $media
                    ]);

                    $item->itemPrices()->saveMany([
                        ItemPrice::factory(['item_id' => $item->id])->createOne()
                    ]);
                })
                ->create());
        })->create();
    }
}
