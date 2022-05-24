<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Services\LotusNotesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RouteApprovalController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \JsonException
     */
    public function __invoke(Request $request, Route $route)
    {
        $input = $request->all();

        $route->load(['applications', 'users', 'applications.stations', 'applications.works', 'applications.project', 'area', 'user', 'engineer']);

       
        $employee = collect($this->isLotus($route->engineer));
        $places = array($route->area->title);
        foreach ($route->users as $user) {
            $employee->push($this->isLotus($user));
        }
        if (!$route->addresses->isEmpty()) {
            
            foreach ($route->addresses as $address) {
                $places[] = $address->city->title . ' ' . $address->address;
            }
        } else {
            $stations = collect();            
            foreach ($route->applications as $application) {
                foreach ($application->stations as $station) {
                    
                    $stations->push($station);

                }
            }
            $farstations = $stations->where('distance', $stations->max('distance'));
            
            foreach ($farstations as $key => $value) {
                $farstation=$value;
            }
            $places[] = $farstation->state->title.', '.$farstation->region->title.', '.$farstation->city->title;
        }
        
        $user = Auth::user();
        $lotus = new LotusNotesService();

        $lotus->setApplications($route->applications);
       
        $lotus->setTitle($route->id);
        if ($route->order_unid) {
        $lotus->setOrderUnid($route->order_unid );
        }
        if ($route->unid) {
        $lotus->setRouteUnid($route->unid );
        }
        $lotus->setArea(implode(', ', $places));
        $lotus->setAuthor($user->lotus_login);
        $lotus->setResponsible($this->isLotus($route->area->division->user));
        $lotus->setScheduleType('planned');
        $lotus->setStartDate($route->started_at);
        $lotus->setEndDate($route->deadline_at);
        $lotus->setEmployee($employee);
        $lotus->setMileage($route->distance);
        $lotus->setTransport($route->vehicle_type_id);
        if($route->vehicle){
        $lotus->setTransportNumber($route->vehicle->number);
        }
        $response = $lotus->makeRequest();
        if (!empty($response !== null && $response['result'] === 'SUCCESS')) {
            $route->unid = $response['UNID'];
            $route->save();
        }

        return redirect()->back();
    }

    public function isLotus($user)
    {
        isset($user->lotus_login) ? $a = $user->lotus_login : $a = $user->lastname . ' ' . $user->firstname . ' ' . $user->middlename;
        return $a;

    }
}
