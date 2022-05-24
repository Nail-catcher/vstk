<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActEquipmentInstallationSheet implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($station, $startings )
    {
        $this->station = $station;
        $this->startings = $startings;
        $this->today = Carbon::today()->format('Y-m-d');
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects.actEquipmentInstallation',
            [
                'station' => $this->station,
                'startings' => $this->startings,
                'today' => $this->today
            ]
        );
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->station->bts_id;
    }
}
