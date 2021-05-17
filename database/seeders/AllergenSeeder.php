<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $allergens = [
            'Glutén', 'Rák', 'Tej', 'Tojás', 'Hal', 'Földimogyoró', 'Szójabab', 'Diófélék', 'Zeller', 'Mustár', 'Szezámmag', 'Csillagfürt', 'Puhatestűek'
        ];

        foreach ($allergens as $allergen) {
            Allergen::updateOrCreate(['name' => $allergen]);
        }
    }
}
