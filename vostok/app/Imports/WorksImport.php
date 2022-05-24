<?php

namespace App\Imports;

use App\Models\Work;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorksImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Work|void
     */
    public function model(array $row)
    {
        if (empty($row['vid_rabot'])) {
            return;
        }
        return new Work([
            'title' => $row['vid_rabot']
        ]);
    }
}
