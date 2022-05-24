<?php

namespace App\Imports;

use App\Models\Place;
use App\Models\Division;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlacesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        $division = Division::where('title', '=', $row['rp'])->first();
        return new Place([
            'division_id' => $division->id,
            'title' => $row['naimenovanie'],
            'address' => $row['adres'],
            'location' => new Point($row['sirota'], $row['dolgota'])
        ]);
    }
}
