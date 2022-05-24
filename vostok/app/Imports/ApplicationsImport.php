<?php

namespace App\Imports;

use App\Models\Application;
use App\Models\Project;
use App\Models\Station;
use App\Models\Type;
use App\Models\User;
use App\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class ApplicationsImport implements  ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, OnEachRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
       $PCREpattern  =  '/\r\n|\r|\n/u';
      
       $bts =  explode("," , preg_replace($PCREpattern, '', $row['bs_id']));
       $usrs = explode(",", preg_replace($PCREpattern, '',  $row['sotrudniki_rpeu'] ));
       
       $listBs = [];
       $listUser = []; 
       foreach ($bts as $key => $value) {
           if (Station::where('bts_id', '=',  ltrim($value, ' '))->exists()){
          array_push($listBs,Station::where('bts_id', '=',  ltrim($value, ' '))->first());
          }
       }
      
       foreach ($usrs as $key => $value) {
           if (User::where('lastname', '=', Str::before(ltrim($value, " "), ' '))->exists()){
          array_push($listUser, User::where('lastname', '=', Str::before(ltrim($value, " "), ' '))->first());
          }
       }
       
        if (!empty($listBs)) {
            $station = $listBs[0];
            $type = Type::where('title', '=', $row['vid_rabot'])->first();
            $project = Project::where('title', '=', Str::before($row['proekt'], ' '))->first();
            $application = new Application([
                'deadline_at' => (new Carbon(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['data_okoncaniya'])))->setTime(23, 59, 59),
            ]);
            $user = $listUser[0] ??  User::where('lastname', '=', Str::before(ltrim($row['otvetstvennyi_rpeu'], " "), ' '))->first();
            $work = Work::where('title', '=', $row['opisanie_rabot'])->first();
           
            $application->user()->associate($station->area->division->user);
            $application->division()->associate($station->area->division);
            $application->area()->associate($station->area);
            $application->project()->associate($project);
            $application->engineer()->associate($user);
            $application->type()->associate($type);
            $application->work()->associate($work ?? 38);
            $application->save();
            foreach ($listUser as $key => $value) {
            $application->users()->attach($value);
            }
            foreach ($listBs as $key => $value) {
            $application->stations()->attach($value);
            }
            $application->dispatcher()->associate(Auth::id());
            $optimized = (new \App\Services\MapBoxService())->getOptimizedTrips(
                'mapbox/driving-traffic',
                array_merge([
                    "{$application->area->location->getLng()},{$application->area->location->getLat()}"
                ],
                    $application->stations->map(function ($station) {
                        return "{$station->location->getLng()},{$station->location->getLat()}";
                    })->toArray()
                ));
            $optimized = json_decode($optimized, true);
            $application->distance = $optimized['trips'][0]['distance'];
            $application->save();
            return $application;
        }
    }
      public function chunkSize(): int
    {
        return 100;
    }

    /**
     * @param Row $row
     */
    public function onRow(Row $row)
    {
        
        $row = $row->toArray();
       $PCREpattern  =  '/\r\n|\r|\n/u';
       $bts =  explode("," , preg_replace($PCREpattern, '', $row['bs_id']));
       $usrs = explode(",", preg_replace($PCREpattern, '', Str::before(ltrim($row['sotrudniki_rpeu'], " "), ' ')));
       
       $listBs = [];
       $listUser = [];   
       
       foreach ($bts as $key => $value) {
           if (Station::where('bts_id', '=', ltrim($value, ' '))->exists()){
          array_push($listBs,Station::where('bts_id', '=', ltrim($value, ' '))->with(['area','area.division','area.division.user'])->first());
          }
       }
      
       foreach ($usrs as $key => $value) {
           if (User::where('lastname', '=', $value)->exists()){
          array_push($listUser, User::where('lastname', '=', $value)->first());
          }
       }
       
        if (!empty($listBs) and !empty($listUser)) {
            $station = $listBs[0];
            Log::info($listBs);
            Log::info($listUser);
            $type = Type::where('title', '=', $row['vid_rabot'])->first();
            $project = Project::where('title', '=', Str::before($row['proekt'], ' '))->first();
            $application = new Application([
                'deadline_at' => (new Carbon(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['data_okoncaniya'])))->endOfDay()
            ]);
            $user = $listUser[0] ?? Str::before(ltrim($row['otvetstvennyi_rpeu'], " "), ' ');
            $work = Work::where('title', '=', $row['opisanie_rabot'])->first();
            $application->user()->associate($station->area->division->user);
            $application->division()->associate($station->area->division);
            $application->area()->associate($station->area);
            $application->project()->associate($project);
            $application->engineer()->associate($user);
            $application->type()->associate($type);
            $application->work()->associate($work ?? 38);
            $application->save();
            foreach ($listUser as $key => $value) {
            $application->users()->attach($value);
            }
            foreach ($listBs as $key => $value) {
            $application->stations()->attach($value);
            }
            $application->dispatcher()->associate(Auth::id());
            $optimized = (new \App\Services\MapBoxService())->getOptimizedTrips(
                'mapbox/driving-traffic',
                array_merge([
                    "{$application->area->location->getLng()},{$application->area->location->getLat()}"
                ],
                    $application->stations->map(function ($station) {
                        return "{$station->location->getLng()},{$station->location->getLat()}";
                    })->toArray()
                ));
            $optimized = json_decode($optimized, true);
            $application->distance = $optimized['trips'][0]['distance'];
            $application->save();

        }

    }
}
