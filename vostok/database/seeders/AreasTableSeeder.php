<?php

namespace Database\Seeders;

use App\Imports\AreasImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new AreasImport(), storage_path('data/divisions_areas.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
