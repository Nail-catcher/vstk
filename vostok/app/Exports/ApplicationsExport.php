<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicationsExport implements FromView
{

    private $applications;

    /**
     * ApplicationsExport constructor.
     * @param $applications
     */
    public function __construct($applications)
    {

        $this->applications = $applications;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.statistics.applications', [
            'applications' => $this->applications,
        ]);
    }
}
