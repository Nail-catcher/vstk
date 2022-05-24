<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportOperatorPPR implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($stations, array $input)
    {
        $this->stations = $stations;
        $this->start = $input['start'];
        $this->end = $input['end'];
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects.reportOperatorPPR', [
            'stations' => $this->stations,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "Отчет ППР операторов ( $this->start - $this->end)";
    }
}
