<?php

namespace Database\Seeders;

use App\Imports\WorksImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new WorksImport(), storage_path('data/works.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
