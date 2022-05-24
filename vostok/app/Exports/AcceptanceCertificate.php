<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AcceptanceCertificate implements FromView, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct()
    {
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects.acceptanceCertificate');
    }
}
