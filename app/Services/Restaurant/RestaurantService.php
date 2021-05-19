<?php

namespace App\Services\Restaurant;

use App\Models\Allergen;
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
        $item->update($request->only(['name', 'description', 'make_time', 'available_from', 'available_to']) + ['restaurant_id' => $restaurant->id]);

        $this->updateItemPrice($item, $request);
        $this->updateItemImages($item, $request->file('media'));
        $this->updateItemAllergens($item, $request->get('allergens', []));
    }

    public function createItem(Restaurant $restaurant, Request $request): void
    {
        $item = Item::create($request->only(['name', 'description', 'make_time']) + ['restaurant_id' => $restaurant->id]);

        $this->updateItemPrice($item, $request);
        $this->updateItemImages($item, $request->file('media'));
        $this->updateItemAllergens($item, $request->get('allergens', []));
    }

    private function updateItemAllergens(Item $item, array $allergens): void
    {
        $allergenList = collect($allergens)->map(fn($value, $key) => $key);
        $item->allergens()->sync($allergenList);
    }

    private function updateItemPrice(Item $item, Request $request): void
    {
        if ($item->mainPrice !== null && $item->mainPrice->id !== null) {
            $item->mainPrice->update([
                'price' => $request->get('price'),
                'discount_type' => $request->get('discount_type') === '0' ? null : $request->get('discount_type'),
                'discount' => $request->get('discount', 0) ?? 0,
            ]);
        } else {
            ItemPrice::create([
                'item_id' => $item->id,
                'currency_id' => Currency::where('code', 'HUF')->first()->id,
                'price' => $request->get('price'),
                'discount_type' => $request->get('discount_type') === '0' ? null : $request->get('discount_type'),
                'discount' => $request->get('discount', 0) ?? 0,
            ]);
        }
    }

    private function updateItemImages(Item $item, $files): void
    {
        if (is_array($files) && count($files) > 0) {
            $images = [];
            foreach ($files as $file) {
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
