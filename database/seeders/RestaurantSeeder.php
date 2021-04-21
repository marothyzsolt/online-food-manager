<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::create([
            'user_id' => 1,
            'name' => 'Teszt étterem',
            'description' => 'Szeretettel várjuk Önöket a megújult kertvendéglőnkben, sörözőnkben. Már az 1960-as években is működött itt vendéglátó egység hol cukrászdaként, hol bisztróként, majd étteremként.',
            'token' => Str::random(32),
            'slug' => 'test-rest',
            'style' => 'Magyaros',
        ]);
    }
}
