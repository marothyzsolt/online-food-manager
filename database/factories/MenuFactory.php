<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Media\MediaHandler;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        \Storage::disk('public')->makeDirectory('images');
        $mediaHandler = app()->make(MediaHandler::class);

        $imagePath = $this->faker->image('storage/app/public/images', 640, 480, 'food');
        $imagePath = str_replace('storage/app/public/images/', '', $imagePath);
        $mediaHandler->setDisk('images');
        $media = $mediaHandler->makeMedia($imagePath, Media::MIME_TYPE_PNG);

        return [
            'name' => $this->faker->colorName,
            'description' => $this->faker->realText(),
            'restaurant_id' => Restaurant::all()->random()->id,
            'media_id' => $media ?? $media->id,
        ];
    }
}
