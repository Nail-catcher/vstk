<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LotusNotesService
{
    public string $area;
    public float $mileage;
    public string $author;
    public \DateTime $endDate;
    public string $title;
    public $stations;
    public Collection $applications;
    public string $scheduleType;
    public string $responsible;
    public string $technician;
    public Collect $employee;
    protected $url;
    protected $username;
    protected $password;
    protected $user;

    public function __construct()
    {
        $this->url = config('services.lotus.url');
        $this->username = config('services.lotus.username');
        $this->password = config('services.lotus.password');
        $this->user = Auth::user();
    }

     public function encodeLotus($title)
    {
       
        if ($title=="CDMA") {
            return 'CDMA 450';
        }
        elseif ($title=="АВР") {
            return 'РНР';
        }
        else{
            return $title;
        }


    }
     public function typeLotus()
    {
        $startDate = Carbon::parse($this->startDate)->timestamp;
        $endDate = Carbon::parse($this->endDate)->timestamp;
        $value=$endDate-$startDate;
       
        if ($value<=86401){
            if(isset($this->orderUnid)){
                return ("ORDER-CHANGE");
            } else {
                
                return ("ORDER");
            }
        } else {
            if(isset($this->orderUnid)){
                
                return ("REQUEST-CHANGE");
            } else {
                return ("REQUEST");
            }            
        }      

    }
    public function docUnid()
        {

            if(isset($this->routeUnid)){
                return ($this->routeUnid);
            } else {
                return (null);
            }
        } 
     public function convertToISO()
    {
        $startDate = Carbon::parse()->toIso8601String();
        
        

    }
    /**
     * @param Route|Application $model
     * @return array
     */
    public function getOrderInfo($model): array
    {
        $response = Http::withBasicAuth($this->username, $this->password)
            ->get("{$this->url}TOOLS/API/bs-service-api.nsf/api.xsp/GetOrderInfo", [
                'UNID' => $model->unid
            ]);
        return $response->json();
    }

    /**
     * @param Application $application
     * @return array
     * @throws \JsonException
     */
    public function createRequest(Application $application)
    {
        $request = json_encode([[
            'request' => [
                'author' => $this->user->lotus_login,
                'date' => now(),
                'title' => $application->title,
                'type' => 'REQUEST',
                'business_trip' => [
                    'schedule_type' => $this->getScheduleType($application->type_id),
                    'type' => 'Убытие',
                    'locality' => $application->area->title,
                    'responsible' => $application->user->lotus_login,
                    'start_date' => now(),
                    'end_date' => $application->deadline_at,
                    "transport" => 1,
                    "mileage" => round($application->distance, 2),
                    'employee' => [],
                    'target' => [
                        [
                            'project' => $application->project->title,
                            'type' => $application->work->title,
                            'target' => "{$application->project->title}. {$application->work->title}",
//                                    'budget_item' => '',
//                                    'days_count' => '',
//                                    'nights_count' => '',
                            'base_station' => $this->getStations($application->stations, $application->ticket, $application->comment)
                        ]
                    ]
                ]
            ]
        ]], JSON_THROW_ON_ERROR);
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withBody($request, 'application/json;charset=utf-8')
            ->post("{$this->url}TOOLS/API/bs-service-api.nsf/api.xsp/CreateRequest");
        Log::info($response);
        return $response->json();
    }

    public function getScheduleType($type)
    {
        if ($type === 1) {
            return 'unplanned';
        }
        return 'planned';
    }

    /**
     * @param string $scheduleType
     * @return $this
     */
    public function setScheduleType(string $scheduleType): LotusNotesService
    {
        $this->scheduleType = $scheduleType;
        return $this;
    }
    /**
     * @param string $scheduleType
     * @return $this
     */
    public function setOrderUnid(string $orderUnid): LotusNotesService
    {
        $this->orderUnid = $orderUnid;
        return $this;
    }
    /**
     * @param string $scheduleType
     * @return $this
     */
    public function setRouteUnid(string $routeUnid): LotusNotesService
    {
        $this->routeUnid = $routeUnid;
        return $this;
    }
    protected function getStations($stations, $ticket, $comment)
    {
        return $stations->map(function ($station) use ($ticket, $comment) {
            return [
                'ID' => $station->bts_id,
                'ticket_ID' => $ticket,
                'comments' => $comment
            ];
        })->toArray();
    }

    /**
     * @param string $area
     * @return $this
     */
    public function setArea($area): LotusNotesService
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor(string $author): LotusNotesService
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @param string $responsible
     * @return $this
     */
    public function setResponsible(string $responsible): LotusNotesService
    {
        $this->responsible = $responsible;
        return $this;
    }

    /**
     * @param string $technician
     * @return $this
     */
    public function setTechnician(string $technician): LotusNotesService
    {
        $this->technician = $technician;
        return $this;
    }

    /**
     * @param float $mileage
     * @return $this
     */
    public function setMileage(float $mileage): LotusNotesService
    {

        $this->mileage = round($mileage * 0.001, 2);
        return $this;
    }

    /**
     * @param string $scheduleType
     * @return $this
     */
    public function setTransportNumber(string $transportNumber): LotusNotesService
    {
        $this->transportNumber = $transportNumber;
        return $this;
    }
    /**
     * @param string $scheduleType
     * @return $this
     */
    public function setTransport(string $transport): LotusNotesService
    {
        $this->transport = $transport;
        return $this;
    }
    /**
     * @param \DateTime $startDate
     * @return $this
     */
    public function setStartDate(\DateTime $startDate): LotusNotesService
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @param \DateTime $endDate
     * @return $this
     */
    public function setEndDate(\DateTime $endDate): LotusNotesService
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): LotusNotesService
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @param Collection $employee
     * @return $this
     */
    // public function setNightAdresses(Collect $nightAdresses): LotusNotesService
    // {
    //     $this->nightAdresses = $nightAdresses;
    //     return $this;
    // }
    /**
     * @param Collection $applications
     * @return $this
     */
    public function setApplications(Collection $applications): LotusNotesService
    {
        $this->applications = $applications;
        return $this;
    }
    public function scheduleTypeLotus()
    {
       $collection=$this->applications->map(fn(Application $application) => [            
            "type" => $application->type->title  ]);
       if ($collection-> whereIn('type', ['ППР'])->isEmpty()) {
           return 'unplanned';
       } elseif ($collection-> whereIn('type', ['АВР'])->isEmpty()){
            return 'planned';
       } else {
            return 'mixed';
       }
       
    }
    /**
     * @throws \JsonException
     */
    public function makeRequest()
    {
       
        $request = json_encode([[
            'request' => [
                'author' => $this->author,
                'date' => now()->toIso8601String(),
                'title' => $this->title,
                'type' => $this->typeLotus(),
                "main_doc_unid" => $this->docUnid(),
                'business_trip' => [
                    'schedule_type' => $this->scheduleTypeLotus(),
                    'type' => 'Убытие',
                    'locality' => $this->area,
                    'responsible' => $this->responsible,
                    'start_date' => Carbon::parse($this->startDate)->toIso8601String(),
                    'end_date' => Carbon::parse($this->endDate)->toIso8601String(),
                    "transport" => $this->transport,
                    'transport_number' => $this->transportNumber ?? null,
                    "mileage" => $this->mileage,
                    'employee' => $this->employee,
                    'target' => $this->makeTarget()
                ]
            ]
        ]], JSON_THROW_ON_ERROR);
         //dd(json_decode($request));
        $response = Http::withBasicAuth($this->username, $this->password)
            ->withBody($request, 'application/json;charset=utf-8')
            ->post("{$this->url}TOOLS/API/bs-service-api.nsf/api.xsp/CreateRequest");
            
        Log::info($response);
        return $response->json();
    }


    public function makeTarget()
    {
        return $this->applications->map(fn(Application $application) => [
            'project' => $this->encodeLotus($application->project->title),
            'type' => $this->encodeLotus($application->type->title),
            'target' => $application->work->title,
            'base_station' => $this->getStations($application->stations, $application->ticket, $application->comment)
        ])->toArray();
    }

    protected function getEmployee($users)
    {
        return $users->map(function ($user) {
            return $user->lotus_login;
        });
    }

    /**
     * @param Collection $employee
     * @return $this
     */
    public function setEmployee(Collect $employee): LotusNotesService
    {
        $this->employee = $employee;
        return $this;
    }
   
}
