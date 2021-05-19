<?php

namespace App\Services\Restaurant;

use App\Models\Currency;
use App\Models\Item;
use App\Models\ItemPrice;
use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\IntervalService;
use App\Services\Media\MediaHandler;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RestaurantService
{
    public function __construct(private MediaHandler $mediaHandler, private IntervalService $intervalService)
    {
    }

    public function update(Restaurant $restaurant, array $data, array $days): void
    {
        $restaurant->update($data);

        $this->saveOpeningHours($restaurant, $days);
    }

    public function saveOpeningHours(Restaurant $restaurant, array $days): void
    {
        $openingHours = $this->intervalService->generateInterval(OpeningHour::class, $days);

        $restaurant->openingHours()->delete();
        $restaurant->openingHours()->saveMany($openingHours);
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

    public function getActiveCourier(Restaurant $restaurant): ?User
    {
        $courier = $restaurant
            ->whereHas('couriers.activities', function ($q) {
                $q->where('day', now()->day)
                    ->where('from', '>', now()->hour)
                    ->where('to', '<', now()->hour);
            })
            ->get();

        if ($courier->count() > 0) {
            return $courier->random();
        }

        return null;
    }
}
