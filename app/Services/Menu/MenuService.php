<?php

namespace App\Services\Menu;

use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\Media\MediaHandler;
use Illuminate\Http\UploadedFile;

class MenuService
{
    public function __construct(private MediaHandler $mediaHandler)
    {
    }

    public function store(Restaurant $restaurant, string $name, string $description, ?UploadedFile $image): void
    {
        $media = null;
        if ($image !== null) {
            $media = $this->mediaHandler->storeUploadedMedia($image);
        }
        Menu::create([
            'name' => $name,
            'description' => $description,
            'media_id' => $media?->id,
            'restaurant_id' => $restaurant->id
        ]);
    }

    public function update(Menu $menu, string $name, string $description, ?UploadedFile $image): void
    {
        $data = [
            'name' => $name,
            'description' => $description,
        ];

        if ($image !== null) {
            $media = $this->mediaHandler->storeUploadedMedia($image);
            $data['media_id'] = $media->id;
        }

        $menu->update($data);
    }
}
