<?php

namespace Database\Seeders;

use App\Models\StationType;
use Illuminate\Database\Seeder;

class StationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        StationType::create([
            'title' => 'BTS3606CE'
        ]);
        StationType::create([
            'title' => 'BTS3606C'
        ]);
        StationType::create([
            'title' => 'DBS3900'
        ]);

    }
}
