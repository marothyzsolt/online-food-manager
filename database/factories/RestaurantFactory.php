<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'name' => $this->faker->company,
            'description' => $this->faker->realText(),
            'token' => Str::random(32),
            'slug' => Str::slug($this->faker->unique()->sentence(3)),
            'style' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'address' => $this->faker->address,
        ];
    }
}
