<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActReadingElector implements ShouldAutoSize, WithMultipleSheets
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($stations)
    {
        $this->stations = $stations;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->stations as $station) {
            $sheets[] = new ActReadingElectorSheet($station);
        }
        return $sheets;
    }
}
