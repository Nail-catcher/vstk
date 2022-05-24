<?php

namespace Database\Seeders;

use App\Models\Sensor;
use App\Models\Station;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sensor::create([
            'title' => 'Дым'
        ]);
        Sensor::create([
            'title' => 'Вода'
        ]);
        Sensor::create([
            'title' => 'Температура'
        ]);
        Sensor::create([
            'title' => 'Alarm DC'
        ]);
        Sensor::create([
            'title' => 'Alarm AC'
        ]);
        Sensor::create([
            'title' => 'Alarm Rect.F'
        ]);
        $sensors = Sensor::all();
        Station::chunk(100, function ($stations) use ($sensors) {
            $stations->each(function (Station $station) use ($sensors) {
                $station->sensors()->attach($sensors);
            });
        });
    }
}
