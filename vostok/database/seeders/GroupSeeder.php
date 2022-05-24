<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Station;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Station::chunk(100, function ($stations) {
            $stations->each(function (Station $station) {
                for ($i = 1; $i <= 2; $i++) {
                    Group::factory()->count(1)
                        ->create([
                            'number' => $i,
                            'station_id' => $station->id
                        ]);
                }
            });
        });
    }
}
