<?php

namespace App\Exports;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\WeekendDay;
class WorkloadByProject implements FromView, ShouldAutoSize
{
    private $users;
    /**
     * @var array
     */
    private $input;

    public function __construct($users, array $input)
    {

        $this->users = $users;
        $this->input = $input;
       

        $a = new CarbonPeriod($input['start'], '1 day', $input['end']);

        $b = WeekendDay::select('date')->get();
        $array = array();
        $array1 = array();
        foreach ($b as $date2) {

            $array[]=new Carbon($date2->date);

            }

        foreach ($a as $date) {


            if (!in_array($date,$array)){
                $array1[] = $date;
            }
        }
        $this->period = $array1;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects.workload', [
            'users' => $this->users,
            'period' => $this->period,

        ]);
    }
}
