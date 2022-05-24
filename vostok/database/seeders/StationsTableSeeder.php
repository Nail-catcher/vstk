<?php

namespace Database\Seeders;

use App\Imports\StationsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new StationsImport(), storage_path('data/stations.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
