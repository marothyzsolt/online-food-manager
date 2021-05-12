<?php

namespace App\Services\Restaurant;

use App\Models\Menu;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Services\Media\MediaHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class RestaurantService
{
    public function __construct(private MediaHandler $mediaHandler)
    {
    }

    public function update(Restaurant $restaurant, array $data, array $days): void
    {
        $restaurant->update($data);

        $this->saveOpeningHours($restaurant, $days);
    }

    public function saveOpeningHours(Restaurant $restaurant, array $days): void
    {
        $openingHours = [];
        foreach ($days as $day => $item) {
            if ($day !== null && $item['from'] !== null && $item['to'] !== null) {
                $openingHours[] = $this->generateOpeningHour($day, $item['from'], $item['to']);
            }
        }

        $restaurant->openingHours()->delete();
        $restaurant->openingHours()->saveMany($openingHours);
    }

    private function generateOpeningHour(int $day, int $from, int $to): OpeningHour
    {
        $openingHour = new OpeningHour();
        $openingHour->day = $day;
        $openingHour->from = $from;
        $openingHour->to = $to;

        return $openingHour;
    }

    public function saveImage(Restaurant $restaurant, ?UploadedFile $file): void
    {
        $media = $this->mediaHandler->storeUploadedMedia($file);
        $restaurant->update(['media_id' => $media->id]);
    }
}
