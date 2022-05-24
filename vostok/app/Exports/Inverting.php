<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Inverting implements WithMultipleSheets, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($applications, array $input)
    {
        $this->applications = $applications;
        $this->input = $input;
        $this->start = $input['start'];
        $this->end = $input['end'];
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->applications as $application) {
            foreach ($application->stations as $station) {
                $sheets[] = new InvertingSheet($station);
            }
        }
        return $sheets;
    }
}
