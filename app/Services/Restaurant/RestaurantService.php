<?php

namespace App\Services\Restaurant;

use App\Models\Currency;
use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Services\Media\MediaHandler;
use Illuminate\Http\Request;
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

    public function updateItem(Restaurant $restaurant, Item $item, Request $request): void
    {
        $item->update($request->only(['name', 'description', 'make_time']) + ['restaurant_id' => $restaurant->id]);
        if ($item->mainPrice !== null) {
            $item->mainPrice->update([
                'price' => $request->get('price'),
                'discount_type' => $request->get('discount_type'),
                'discount' => $request->get('discount'),
            ]);
        } else {
             ItemPrice::create([
                'item_id' => $item->id,
                'currency_id' => Currency::where('code', 'HUF')->first()->id,
                'price' => $request->get('price'),
                'discount_type' => $request->get('discount_type'),
                'discount' => $request->get('discount', 0),
            ]);
        }

        if (is_array($request->file('media')) && count($request->file('media')) > 0) {
            $images = [];
            foreach ($request->file('media') as $file) {
                $images[] = $this->mediaHandler->storeUploadedMedia($file);
            }
            $item->images()->saveMany($images);
        }
    }
}
