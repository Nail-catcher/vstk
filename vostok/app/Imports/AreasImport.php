<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Division;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AreasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $division = Division::where('title', '=', $row['regionalnoe_podrazdelenie'])->first();
        $area = new Area([
            'title' => $row['ekspluatacionnye_ucastki'],
            'address' => $row['adres_eu'],
            'location' => new Point($row['sirota_n'], $row['dolgota_e'])
        ]);
        $area->division()->associate($division);
        return $area;
    }
}
