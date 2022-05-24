<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'title' => 'Алматы'
        ]);
        City::create([
            'title' => 'Нур-Султан'
        ]);
        City::create([
            'title' => 'Павлодар'
        ]);
        City::create([
            'title' => 'Актобе'
        ]);
        City::create([
            'title' => 'Шымкент'
        ]);
    }
}
