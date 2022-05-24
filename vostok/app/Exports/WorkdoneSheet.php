<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class WorkdoneSheet implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($application, array $input, $station, array $startings)
    {
        $this->application = $application;
        $this->start = $input['start'];
        $this->end = $input['end'];
        $this->station = $station;
        $this->startings = $startings;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects.workdone', [
            'application' => $this->application,
            'start' => $this->start,
            'end' => $this->end,
            'station' => $this->station,
            'startings' => $this->startings
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->station->bts_id;
    }
}
