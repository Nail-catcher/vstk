<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorkdoneAVR implements WithMultipleSheets, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($application, array $input, $startings)
    {
        $this->application = $application;
        $this->input = $input;
        $this->start = $input['start'];
        $this->end = $input['end'];
        $this->startings = $startings;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
       
        foreach ($this->application->stations as $station) {
            $sheets[] = new WorkdoneAVRSheet($this->application, $this->input, $station, $this->startings);
        }
        return $sheets;
    }
}
