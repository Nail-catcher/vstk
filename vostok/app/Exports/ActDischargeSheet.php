<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActDischargeSheet implements FromView, ShouldAutoSize, WithTitle
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($station)
    {
        $this->station = $station;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view(
            'exports.projects.actDischarge', [
            'station' => $this->station
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
