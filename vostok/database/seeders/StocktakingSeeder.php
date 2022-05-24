<?php

namespace Database\Seeders;

use App\Models\StationType;
use App\Models\Stocktaking;
use Illuminate\Database\Seeder;

class StocktakingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Stocktaking::create([
            'title' => 'STDM'
        ]);
        Stocktaking::create([
            'title' => 'SPAM'
        ]);
        Stocktaking::create([
            'title' => 'RF полка'
        ]);
        Stocktaking::create([
            'title' => 'SPSU'
        ]);
        Stocktaking::create([
            'title' => 'BCIM'
        ]);
        Stocktaking::create([
            'title' => 'CCPM'
        ]);
        Stocktaking::create([
            'title' => 'CECM'
        ]);
        Stocktaking::create([
            'title' => 'BCKM'
        ]);
        Stocktaking::create([
            'title' => 'EMU'
        ]);
        Stocktaking::create([
            'title' => 'PS48300/1800'
        ]);
        Stocktaking::create([
            'title' => 'М500D'
        ]);
        Stocktaking::create([
            'title' => 'R48 – 1800А'
        ]);
        Stocktaking::create([
            'title' => 'АКБ 1-я группа'
        ]);
        Stocktaking::create([
            'title' => 'АКБ 2-я группа'
        ]);
        Stocktaking::create([
            'title' => 'Секторная антенна А'
        ]);
        Stocktaking::create([
            'title' => 'Секторная антенна B'
        ]);
        Stocktaking::create([
            'title' => 'Секторная антенна C'
        ]);
        Stocktaking::create([
            'title' => 'Фидер сектора А'
        ]);
        Stocktaking::create([
            'title' => 'Фидер сектора B'
        ]);
        Stocktaking::create([
            'title' => 'Фидер сектора C'
        ]);
        $types = StationType::all();
        Stocktaking::each(fn(Stocktaking $stocktaking) => $stocktaking->stationTypes()->attach($types));
    }
}
