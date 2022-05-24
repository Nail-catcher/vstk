<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportAVR implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($stations, array $input)
    {
        $this->stations = $stations;
        $this->input = $input;
        $this->start = substr($input['start'], 0, 10);
        $this->end =  substr($input['end'], 0, 10);
        
        

    }

    /**
     * @return View
     */
    public function view(): View
    {

        return view(
            'exports.projects.reportAVR',
            [
                'stations' => $this->stations
            ]
        );
    }

    /**
     * @return string
     */
    public function title(): string
    {
       
        return "АВР ($this->start - $this->end)";
    }
}
