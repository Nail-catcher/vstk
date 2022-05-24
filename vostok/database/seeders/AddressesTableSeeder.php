<?php

namespace Database\Seeders;

use App\Imports\AddressesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new AddressesImport(), storage_path('data/addresses.xlsx'), null, \Maatwebsite\Excel\Excel::XLSX);

    }
}
