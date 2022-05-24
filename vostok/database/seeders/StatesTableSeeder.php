<?php

namespace Database\Seeders;

use App\Imports\StatesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new StatesImport(), storage_path('data/divisions_states.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
