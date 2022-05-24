<?php

namespace Database\Seeders;

use App\Imports\DivisionsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DivisionsImport(), storage_path('data/divisions_areas.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
