<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActDefectSheet implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($application, $station)
    {
        $this->application = $application;
        $this->station = $station;
        $this->today = Carbon::today()->format('Y-m-d');
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view(
            'exports.projects.actDefect',
            [
                'application' => $this->application,
                'station' => $this->station,
                'today' => $this->today
            ]
        );
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Акт дефектовки - " . $this->station->bts_id;
    }
}
