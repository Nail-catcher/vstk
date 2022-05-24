<?php

namespace App\Imports;

use App\Models\Division;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DivisionsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Division
     */
    public function model(array $row): Division
    {
        return Division::firstOrCreate([
            'title' => $row['regionalnoe_podrazdelenie']
        ]);
    }
}
