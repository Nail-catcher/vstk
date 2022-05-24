<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActEquipmentInstallation implements WithMultipleSheets, ShouldAutoSize
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

    /**
     * @return array
     */
    public function sheets(): array
    {
       

        $sheets = [];
        foreach ($this->stations as $station) {  
        $startings = [];          
            foreach ($station->applications as $application) {
                
                foreach ($application->startings as $starting) {
                if ($station->id === $starting->station_id) {
                    $startings[] = $starting;
                }
                
            }
            
        }
        $sheets[] = new ActEquipmentInstallationSheet($station, $startings);
    }
       
        return $sheets;
    }
}
