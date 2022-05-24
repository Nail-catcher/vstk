<?php

namespace Database\Seeders;

use App\Imports\PlacesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Excel::import(new PlacesImport(), storage_path('data/places.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
