<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportByAVRMTC implements FromView, ShouldAutoSize, WithTitle
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
        $this->start = $input['start'];
        $this->end = $input['end'];
        $this->today = Carbon::now()->format('Y-m-d');
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view(
            'exports.projects.ReportByAVRMTC',
            [
                'stations' => $this->stations,
                'start' => $this->start,
                'end' => $this->end,
                'today' => $this->today
            ]
        );
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Отчет по АВР МТС";
    }
}
