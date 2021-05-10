<?php

namespace Database\Factories;

use App\Models\Item;
use Faker\Provider\Base;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Restaurant($this->faker));

        return [
            'name' => $this->faker->foodName,
            'description' => $this->faker->text,
            'make_time' => $this->faker->numberBetween(0, 30)
        ];
    }
}
