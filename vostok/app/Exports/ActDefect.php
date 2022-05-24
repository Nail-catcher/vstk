<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActDefect implements WithMultipleSheets, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->application->stations as $station) {
            $sheets[] = new ActDefectSheet($this->application, $station);
        }
        return $sheets;
    }
}
