<?php

namespace App\Imports;

use App\Models\Address;
use App\Models\City;
use App\Models\Region;
use App\Models\State;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AddressesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Address
     */
    public function model(array $row)
    {
        $state = State::firstOrCreate([
            'title' => $row['oblast']
        ]);
        $region = Region::firstOrCreate([
            'state_id' => $state->id,
            'title' => $row['raion']
        ]);
        $city = City::firstOrCreate([
            'region_id' => $region->id,
            'title' => $row['gorod_naselennyi_punkt']
        ]);
        return new Address([
            'title' => $row['nazvanie_gostinicy'],
            'division_id' => $state->division_id,
            'state_id' => $state->id,
            'region_id' => $region->id,
            'city_id' => $city->id,
            'address' => $row['ulica_dom'] ?? "Без улицы",
            'mci' => $row['kolicestvo_mrp'],
            'cost' => $row['tenge'],
            'location' => new Point($row['sirota'], $row['dolgota']),
        ]);
    }
}
