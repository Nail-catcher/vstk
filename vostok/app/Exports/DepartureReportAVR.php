<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DepartureReportAVR implements FromView
{
    protected $history;
    private $start;
    private $end;

    public function __construct()
    {
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.inventories.departureReportAVR');
    }
}
