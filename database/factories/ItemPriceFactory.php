<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\ItemPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $discountType = $this->faker->boolean(20) ?
            $this->faker->randomElement(ItemPrice::DISCOUNT_TYPE_LIST) :
            null;

        $price = $this->faker->randomFloat(2, 100, 7000);

        return [
            'currency_id' => Currency::first()->id,
            'price' => $price,
            'discount_type' => $discountType,
            'discount' => match ($discountType) {
                ItemPrice::DISCOUNT_TYPE_PRICE => $this->faker->randomFloat(2, 50, $price),
                ItemPrice::DISCOUNT_TYPE_PERCENTAGE => $this->faker->numberBetween(1, 80),
                null => 0
            }
        ];
    }
}
