<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\City;
use App\Models\Region;
use App\Models\State;
use App\Models\Project;
use App\Models\Station;
use App\Models\StationType;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StationsImport implements ToModel, WithHeadingRow
{
    use RemembersRowNumber;

    /**
     * @param array $row
     *
     * @return Station|void
     */
    public function model(array $row)
    {
        if (!empty($row['rasstoyanie_ot'])) {

            if (empty($row['rasstoyanie_ot'])) {
                $row['rasstoyanie_ot']= rand(100000, 999999);
            }
            if (empty($row['oblast'])) {
                $row['oblast']= rand(100000, 999999);
            }
            if (empty($row['raion'])) {
                $row['raion']= rand(100000, 999999);
            }
            if (empty($row['naselennyi_punkt'])) {
                $row['naselennyi_punkt']= rand(100000, 999999);
            }
            $area = Area::where('title', '=', $row['rasstoyanie_ot'])->first();
            
            $state = State::firstOrCreate([
                'division_id' => $area->division_id,
                'title' => $row['oblast']
            ]);
            $region = Region::firstOrCreate([
                'state_id' => $state->id,
                'title' => $row['raion']
            ]);
            $city = City::firstOrCreate([
                'region_id' => $region->id,
                'title' => $row['naselennyi_punkt']
            ]);
           
            
            if (empty($row['site_id'])) {
                $row['site_id']= rand(100000, 999999);
            }
            if (empty($row['tip_bazovoi_stancii'])) {
                $row['tip_bazovoi_stancii']= rand(100000, 999999);
            }
            $type = StationType::firstOrCreate([
                'title' => $row['tip_bazovoi_stancii']
            ]);
            if (empty($row['sirota_n'])) {
                $row['sirota_n'] = '47.267785';
            }
            if (empty($row['dolgota_e'])) {
                $row['sirota_n'] = '65.082063';
            }
            return new Station([
                'project_id' => 2,
                'station_type_id' => $type->id,
                'division_id' => $area->division_id,
                'area_id' => $area->id,
                'location' => new Point($row['sirota_n'], $row['dolgota_e']),
                'state_id' => $state->id,
                'region_id' => $region->id,
                'city_id' => $city->id,
                'bts_id' => $row['site_id'],
                'rac' => $row['naimenovanie_bs_na_rac']?? null,
                'title' => $row['bazovaya_stanciya_osnovnoe_sredstvo'],
                'base_station_type' => $row['tip_bazovoi_stancii']?? null,
                'type_steel_structure' => $row['tip_opory']?? null,
                'supply' => $row['postavka']?? null,
                'distance' => $row['rasstoyanie_km'] ?? 0,
                'prop_height' => $row['vysota_opory_m']  ?? 0,
                'prop_type' => $row['tip_opory']?? null,
                'antenna_suspension_height_a' => $row['vysota_podvesa_antenny_a'] ?? 0,
                'antenna_suspension_height_b' => $row['vysota_podvesa_antenny_v'] ?? 0,
                'antenna_suspension_height_c' => $row['vysota_podvesa_antenny_s'] ?? 0,
                'antenna_azimuths_tilt_angle_a' => $row['azimuty_antennugol_naklona_a'] ?? 0,
                'antenna_azimuths_tilt_angle_b' => $row['azimuty_antennugol_naklona_v'] ?? 0,
                'antenna_azimuths_tilt_angle_c' => $row['azimuty_antennugol_naklona_s'] ?? 0,
                'equipment_installation_location' => $row['mesto_ustanovki_oborudovaniya'] ?? 0,
                'antenna_installation_location' => $row['mesto_ustanovki_antenn'] ?? 0,
                'guaranteed_power' => $row['nalicie_garantirovanogo_pitaniya_ot_dga'] ?? 0,
                'stand_type' => $row['tip_stoiki_ep'] ?? 0,
                'rectifier_units_type' => $row['tip_vypryamitelnyx_blokov'] ?? 0,
                'number_rectifier_units' => $row['kol_vo_vypryamitelnyx_blokov'] ?? 0,
                'battery_capacity' => $row['emkost_akb_a'] ?? 0,
                'battery_count' => $row['kol_vo_akb'] ?? 0,
                'priority' => $row['priority'] ?? 0,
                'order_number' => $row['nomer_zakaza'] ?? 0,
                'order_additional' => $row['dopolnenie_k_zakazu'] ?? 0,
                'subcon' => $row['subcon'] ?? null,
                'comment' => $row['primecanie'] ?? null
            ]);

        }

//    /**
//     * @return int
//     */
//    public function chunkSize(): int
//    {
//        return 200;
//    }
    }
}
