<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StatesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\DatabaStationsTableSeederse\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $division = Division::where('title', '=', $row['regionalnoe_podrazdelenie'])->first();
        $state = new State([
            'title' => $row['oblast']
        ]);
        $state->division()->associate($division);
        return $state;
    }
}
