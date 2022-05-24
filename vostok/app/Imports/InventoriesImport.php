<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Inventory;
use Faker\Factory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoriesImport implements ToModel, WithHeadingRow, WithStyles
{
    /**
     * @param array $row
     *
     * @return \App\Models\Inventory
     */
    public function model(array $row)
    {
        $faker = Factory::create();
        if (!empty($row['tip_oborudovaniya'])) {
            $category = Category::firstOrCreate([
                'title' => $row['tip_oborudovaniya']
            ]);
        }
        return new Inventory([
            'category_id' => $category->id ?? null,
            'rrs' => $row['tip_rrs'],
            'range' => $row['diapazon'],
            'title' => $row['naimenovanie'],
            'manufacturer_code' => $row['proizvoditel_kod'],
            'serial_number' => $row['seriinyi_nomer'],
            'barcode' => $faker->ean13,
            'barcode_type' => 'ean13',
        ]);
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A5:I5')->getFont()->setBold(true);
    }
}
