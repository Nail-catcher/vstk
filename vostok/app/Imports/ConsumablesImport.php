<?php

namespace App\Imports;

use App\Models\Consumable;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsumablesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $unit = Unit::firstOrCreate([
            'title' => $row['ed_izmereniya']
        ]);
        return new Consumable([
            'title' => $row['naimenovanie'],
            'unit_id' => $unit->id,
            'spm' => $row['rasxod_materialov_dlya_provedeniya_avr_na_bs_mt_s_na_1_bs'],
            'atr' => $row['rasxod_materialov_dlya_provedeniya_ppr_na_bs_mt_s_na_1_bs'],
            'cost' => null
        ]);
    }
}
