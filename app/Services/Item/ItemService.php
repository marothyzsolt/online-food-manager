<?php

namespace App\Services\Item;

use App\Models\Currency;
use App\Models\Item;
use App\Models\ItemPrice;
use Illuminate\Http\Request;

class ItemService
{
    /**
     * ItemService constructor.
     */
    public function __construct(private Currency $currency)
    {
    }

    public function store(Request $request, ?Item $item = null): Item
    {
        $data = $request->only(['name', 'description']);
        if ($item === null) {
            $item = Item::create($data);
        } else {
            $item->update($data);
        }

        $this->storePrice(
            $item,
            $request->get('price'),
            $request->get('discount_type'),
            $request->get('discount_value')
        );

        return $item;
    }

    public function storePrice(Item $item, float $price, ?string $discountType = null, float $discountValue = 0): ItemPrice
    {
        return ItemPrice::create([
            'item_id' => $item->id,
            'price' => $price,
            'currency_id' => $this->currency->id,
            'discount_type' => $discountType,
            'discount' => $discountValue,
        ]);
    }

    public function delete(Item $item): void
    {
        // TODO image delete, with MediaHandler Service

        $item->itemPrices()->delete();
        $item->delete();
    }
}