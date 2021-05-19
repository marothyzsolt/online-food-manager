<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\Media;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\Media\MediaHandler;
use App\Services\Restaurant\RestaurantService;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    private Generator $faker;

    /**
     * MenuSeeder constructor.
     */
    public function __construct(private RestaurantService $restaurantService)
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
        $mediaHandler = app()->make(MediaHandler::class);
        $imagePath = $this->faker->randomImage('images', '', 850, 480, 'restaurant');
        $mediaHandler->setDisk('images');
        $media = $mediaHandler->makeMedia($imagePath, Media::MIME_TYPE_PNG);

        /** @var Restaurant $restaurant */
        $restaurant = Restaurant::create([
            'user_id' => 1,
            'name' => 'Teszt étterem',
            'description' => 'Szeretettel várjuk Önöket a megújult kertvendéglőnkben, sörözőnkben. Már az 1960-as években is működött itt vendéglátó egység hol cukrászdaként, hol bisztróként, majd étteremként.',
            'token' => Str::random(32),
            'slug' => 'test-rest',
            'style' => 'Magyaros',
            'media_id' => $media->id,
            'phone' => '+36201234567',
            'email' => 'info@restaurant.hu',
            'address' => '1111 Budapest, Vár utca 23',
        ]);

        $this->restaurantService->saveOpeningHours($restaurant, [
            0 => ['from' => 0, 'to' => 24],
            1 => ['from' => 0, 'to' => 24],
            2 => ['from' => 0, 'to' => 24],
            3 => ['from' => 0, 'to' => 24],
            4 => ['from' => 0, 'to' => 24],
            5 => ['from' => 0, 'to' => 24],
            6 => ['from' => 0, 'to' => 24],
        ]);
        $restaurant->couriers()->save(User::where('email', 'courier@user.com')->first());

        Restaurant::factory()->count(5)->afterCreating(function (Restaurant $restaurant) use ($mediaHandler) {
            $imagePath = $this->faker->randomImage('images', '', 850, 480, 'restaurant');
            $mediaHandler->setDisk('images');
            $media = $mediaHandler->makeMedia($imagePath, Media::MIME_TYPE_PNG);

            $restaurant->update(['media_id' => $media->id]);
        })->create();
    }
}
