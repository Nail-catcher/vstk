<?php

namespace Database\Seeders;

use App\Imports\ConsumablesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ConsumablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Excel::import(new ConsumablesImport(), storage_path('data/consumables.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
