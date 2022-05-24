<?php

namespace Database\Seeders;

use App\Imports\InventoriesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new InventoriesImport(), storage_path('data/inventories.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);
    }
}
