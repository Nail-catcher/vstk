<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

class InventoryUser implements FromView
{
    protected $history;
    private $start;
    private $end;

    public function __construct($history, $start = null, $end = null)
    {
        $this->history = $history;
        if (empty($start)) {
            $start = $this->history->sortBy('created_at')->first()->created_at;
        }
        if (empty($end)) {
            $end = $this->history->sortBy('created_at')->first()->created_at;
        }
        $this->start = new Carbon($start);
        $this->end = new Carbon($end);
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.inventories.history', [
            'history' => $this->history,
            'start' => $this->start,
            'end' => $this->end
        ]);
    }
}
