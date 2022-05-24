<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Workdone implements WithMultipleSheets, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($application, array $input)
    {
        $this->application = $application;
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
        foreach ($this->application->stations as $station) {
            $startings = [];
            foreach ($this->application->startings as $starting) {
                if ($station->id === $starting->station_id) {
                    $startings[] = $starting;
                }
                
            }
            $sheets[] = new WorkdoneSheet($this->application, $this->input, $station, $startings);
        }
        return $sheets;
    }
}
