<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Division;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehiclesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Vehicle
     */
    public function model(array $row): Vehicle
    {
        $area = Area::where('title', '=', trim($row['eu']))->first();
        $division = Division::where('title', '=', $row['rp'])->first();

        return new Vehicle([
            'number' => $row['nomer_masiny'],
            'title' => $row['avtomobil'],

            'division_id' => $division->id,
            'area_id' => $area->id,

            'basic' => $row['bazovaya'],
            'summer' => $row['letnyaya'],
            'winter' => $row['zimnyaya'],
        ]);
    }
}
