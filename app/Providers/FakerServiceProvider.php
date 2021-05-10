<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      //  $this->app->singleton(Factory::class, function () {
       //     return $this->app->make(Factory::class);
     //   });

        $faker = app()->make(Generator::class);
        $newClass = new class($faker) extends Base {
            public function randomImage(string $disk, string $path, int $width, int $height, string $category): string
            {
                $path .= '/' . uniqid() . '.jpg';
                $url = 'https://loremflickr.com/'.$width.'/'.$height.'/'.$category;
                $content = file_get_contents($url);
                Storage::disk($disk)->put($path, $content);
                return $path;
            }
        };

        $faker->addProvider($newClass);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
