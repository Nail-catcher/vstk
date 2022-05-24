<?php

namespace App\Http\Controllers;

use App\Exports\AcceptanceCertificate;
use App\Exports\ActDefect;
use App\Exports\ActDischarge;
use App\Exports\ActEquipmentInstallation;
use App\Exports\ActReadingElector;
use App\Exports\DepartureReportAVR;
use App\Exports\Inverting;
use App\Exports\MaterialStatement;
use App\Exports\ReportAVR;
use App\Exports\ReportByAVRMTC;
use App\Exports\ReportOperatorPPR;
use App\Exports\Workdone;
use App\Exports\WorkdoneAVR;
use App\Exports\WorkloadByProject;
use App\Http\Requests\AcceptanceCertificateRequest;
use App\Http\Requests\ActDefectRequest;
use App\Http\Requests\ActDischargeRequest;
use App\Http\Requests\ActEquipmentInstallationRequest;
use App\Http\Requests\ActReadingElectorRequest;
use App\Http\Requests\ApplicationFilter;
use App\Http\Requests\DepartureReportAVRRequest;
use App\Http\Requests\InvertingSheetRequest;
use App\Http\Requests\MaterialStatementRequest;
use App\Http\Requests\ReportAVRRequest;
use App\Http\Requests\ReportByAVRMTCRequest;
use App\Http\Requests\ReportOperatorPPRRequest;
use App\Http\Requests\ReportWorkdoneAVRRequest;
use App\Http\Requests\ReportWorkdoneRequest;
use App\Http\Requests\ReportWorkloadRequest;
use App\Models\Application;
use App\Models\Starting;
use App\Models\Area;
use App\Models\Division;
use App\Models\Document;
use App\Models\Station;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ApplicationFilter $request
     * @return \Inertia\Response
     */
    public function index(ApplicationFilter $request): \Inertia\Response
    {
        $input = $request->validated();
        $areas = Area::with([
            'applications' => function ($query) use ($input) {
                $query->filter($input)
                    ->limit(5)
                    ->latest('id');
            },
            'applications.user:id,lastname,firstname',
            'applications.engineer:id,lastname,firstname',
            'applications.project',
            'applications.routes',
            'applications.type',
            'applications.stations',
            'applications.works',
            'applications.status',
        ])->get();
        return Inertia::render('Reports/Index', [
            'areas' => $areas,
            'divisions' => Division::all(),
            'documents' => Document::all()
        ]);
    }

    /**
     * @param ReportWorkloadRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function workload(ReportWorkloadRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $input['start'] = new Carbon($input['start']);
        $input['end'] = new Carbon($input['end']);
        if(!empty($input['division'])){
        $users = User::with([
            'applications' => function ($query) use ($input) {
                $query
                    ->select(['id', 'engineer_id', 'type_id', 'ended_at'])
                    
                    ->where('division_id', '=', $input['division'])
                    ->whereBetween('ended_at', [
                        $input['start'],
                        $input['end']
                    ]);
            },
            'applicationsForEngineers' => function ($query) use ($input) {
                $query
                    ->select(['id', 'engineer_id', 'type_id', 'ended_at'])
                    
                    ->where('division_id', '=', $input['division'])
                    ->whereBetween('ended_at', [
                        $input['start'],
                        $input['end']
                    ]);
            },
            'division',
            'position',
            'vacations'
        ])
            ->where('division_id', '=', $input['division'])
            ->whereHas('roles', function (Builder $query) {
                $query->where('slug', '=', 'engineer');
            })
            ->get();
        } else {
             $users = User::with([
            'applications' => function ($query) use ($input) {
                $query
                    ->select(['id', 'engineer_id', 'type_id', 'ended_at'])
                    
                    ->whereBetween('ended_at', [
                        $input['start'],
                        $input['end']
                    ]);
            },
            'applicationsForEngineers' => function ($query) use ($input) {
                $query
                    ->select(['id', 'engineer_id', 'type_id', 'ended_at'])
                    
                    ->whereBetween('ended_at', [
                        $input['start'],
                        $input['end']
                    ]);
            },
            'division',
            'position',
            'vacations'
        ])            
            ->whereHas('roles', function (Builder $query) {
                $query->where('slug', '=', 'engineer');
            })
            ->get();
        }
        //dd($users);
        return Excel::download(new WorkloadByProject($users, $input), "workload.xlsx");
    }

    /**
     * @param ReportWorkdoneRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function workdoneAVR(ReportWorkdoneAVRRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $application = Application::where('id', $input['application_id'])
                ->with(['stations', 'stations.inventories', 'engineer', 'users', 'user', 'startings.progresses.inventories'])->first();
        
        $startings = Starting::where('application_id', '=' , $input['application_id'])->with(['progresses.inventories'])->first();

        //dd($startings);
         
         //return dd($inventories);

        return Excel::download(new WorkdoneAVR($application, $input, $startings), 'workdoneAVR.xlsx');

    }

    /**
     * @param ActReadingElectorRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actReadingElector(ActReadingElectorRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $stations = Station::whereIn('id', $input['stations'])->where('area_id', $input['area_id'])->with(['city', 'region'])->get();
        return Excel::download(new ActReadingElector($stations), 'actReadingElector.xlsx');
    }

    /**
     * @param ActDefectRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actDefect(ActDefectRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $application = Application::where('id', $input['application_id'])->where('area_id', $input['area_id'])
            ->with(['stations', 'user', 'stations.area', 'stations.city', 'stations.region'])->first();
        return Excel::download(new ActDefect($application), 'actDefect.xlsx');
    }

    /**
     * @param InvertingSheetRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function invertingSheet(InvertingSheetRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $applications = Application::whereIn('id', $input['applications'])->where('created_at', '>=', new Carbon($input['start']))->where('created_at', '<=', new Carbon($input['end']))
            ->with('stations', 'stations.area', 'stations.city')->get();
        return Excel::download(new Inverting($applications, $input), 'invertingSheet.xlsx');
    }

    /**
     * @param ReportWorkdoneRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function workdone(ReportWorkdoneRequest $request)
    {
        $input = $request->validated();
        
            
        $application = Application::where('id', $input['application_id'])
            ->whereIn('status_id', [7,8])
            ->with([
            'stations', 'stations.inventories', 'users', 'user', 'startings',
            'startings.type',
            'engineer',
            'startings.user',
            'startings.station:id,bts_id,location',
            'startings.progresses',
            'startings.progresses.typeable',
            'startings.progresses.typeable.modelable',
            'startings.progresses.progress',
            'startings.progresses.inventories',
            'startings.progresses.works',
        ])->first();
        //dd($application);
        try {
            return Excel::download(new Workdone($application, $input), 'workdone.xlsx');
        } catch (Exception  $e) {
            return redirect()->back();
        }
    }

    /**
     * @param MaterialStatementRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function materialStatement(MaterialStatementRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        return Excel::download(new MaterialStatement(), 'materialStatement.xlsx');
    }

    /**
     * @param DepartureReportAVRRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function departureReportAVR(DepartureReportAVRRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        return Excel::download(new DepartureReportAVR(), 'departureReportAVR.xlsx');
    }

    /**
     * @param AcceptanceCertificateRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function acceptanceCertificate(AcceptanceCertificateRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        return Excel::download(new AcceptanceCertificate(), 'acceptanceCertificate.xlsx');
    }

    /**
     * @param ReportOperatorPPRRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function reportOperatorPPR(ReportOperatorPPRRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $stations = [];
        if (!empty($input['stations'])) {
            $stations = Station::whereIn('id', $input['stations'])->with(['applications' => function ($query) use ($input) {
                $query->with(['users', 'area', 'project', 'stations','routes','engineer'])->where('status_id', [7])->where('type_id', 2)->where('ended_at', '>=', new Carbon($input['start']))->where('ended_at', '<=', new Carbon($input['end']));
            }, 'state', 'region', 'city'])->get();
        } else {
            $stations = Station::with(['applications' => function ($query) use ($input) {
                $query->with(['users', 'area', 'project', 'stations', 'routes','engineer'])->where('status_id', [7])->where('type_id', 2)->where('ended_at', '>=', new Carbon($input['start']))->where('ended_at', '<=', new Carbon($input['end']));
            }, 'state', 'region', 'city'])->get();
        }
        //dd($stations);
        return Excel::download(new ReportOperatorPPR($stations, $input), 'reportOperatorPPR.xlsx');
    }

    /**
     * @param ReportByAVRMTCRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */

    public function reportByAVRMTC(ReportByAVRMTCRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        if (!empty($input['stations'])) {
            
            $stations = Station::whereIn('id', $input['stations'])
            ->whereHas('applications', function ($query) use ($input) {
                $query->with(['status'])
                        ->where('status_id', [7,8])
                        ->where('type_id', 1)
                        // ->where('project_id', 2) 
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
            })
            ->with(['area', 'applications' => function ($query) use ($input) {
                $query->with(['status'])
                         ->where('status_id', [7,8])
                         ->where('type_id', 1)
                         // ->where('project_id', 2)              
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
                }])->get();
            
        } else {
             if(!empty($input['area_id'])){
                
                $stations = Station::where('area_id', '=' ,$input['area_id'])
                ->whereHas('applications' , function ($query) use ($input) {
                $query->with(['status'])
                        ->where('status_id', [7,8])
                        ->where('type_id', 1)
                        // ->where('project_id', 2) 
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
                })
                ->with(['area','applications' => function ($query) use ($input) {
                        $query->with(['status'])
                        ->where('status_id', [7,8])
                        ->where('type_id', 1)
                        // ->where('project_id', 2)              
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
                }])->get();

            }else {
            $stations = Station::whereHas('applications' , function ($query) use ($input) {
                $query->with(['status'])
                        ->where('status_id', [7,8])
                        ->where('type_id', 1)
                        // ->where('project_id', 2) 
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
            })
            ->with(['applications' => function ($query) use ($input) {
                $query->with(['status'])
                        ->where('status_id', [7,8])
                        ->where('type_id', 1)
                        // ->where('project_id', 2) 
                        ->where('ended_at', '>=', new Carbon($input['start']))
                        ->where('ended_at', '<=', new Carbon($input['end']));
            }, 'region', ])->get();
        }
        }
        
        return Excel::download(new ReportByAVRMTC($stations, $input), 'report-by-avr-mtc.xlsx');
    }

    /**
     * @param ReportAVRRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function reportAVR(ReportAVRRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();        
        if (!empty($input['stations'])) {
            if(!empty($input['area_id'])){
                $stations = Station::whereIn('id', $input['stations'])->with(['applications.engineer','applications' => function ($query) use ($input) {
            $query->with(['users', 'area', 'project'])
                ->where('status_id', [7,8])->where('type_id', 1)
            ->where('area_id', '=' ,$input['area_id'])
            ->where('ended_at', '>=', new Carbon($input['start']))
            ->where('ended_at', '<=', new Carbon($input['end']));
        }])->get();
            } else {
            $stations = Station::whereIn('id', $input['stations'])->with(['applications.engineer','applications' => function ($query) use ($input) {
            $query->with(['users', 'area', 'project'])->where('status_id', [7,8])->where('type_id', 1)->where('ended_at', '>=', new Carbon($input['start']))->where('ended_at', '<=', new Carbon($input['end']));
        }])->get();

        }} else {
            if(!empty($input['division'])){
            $stations = Station::with(['applications.engineer','applications' => function ($query) use ($input) {
            $query->with(['users', 'area', 'project'])
                ->where('status_id', [7,8])->where('type_id', 1)
            ->where('area_id', '=' ,$input['area_id'])
            ->where('ended_at', '>=', new Carbon($input['start']))
            ->where('ended_at', '<=', new Carbon($input['end']));
        }])->get();
        } else {
            $stations = Station::with(['applications.engineer','applications' => function ($query) use ($input) {
            $query->with(['users', 'area', 'project'])
                ->where('status_id', [7,8])->where('type_id', 1)
            ->where('ended_at', '>=', new Carbon($input['start']))
            ->where('ended_at', '<=', new Carbon($input['end']));
        }])->get();
        }
        }
        
        return Excel::download(new ReportAVR($stations, $input), 'reportAVR.xlsx');
    }


    /**
     * @param ActEquipmentInstallationRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actEquipmentInstallation(ActEquipmentInstallationRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        
        if (!empty($input['stations'])) {
            $stations = Station::whereIn('id', $input['stations'])
                ->where('area_id', $input['area_id'])                
                ->with('city', 'region','applications','applications.startings.progresses.inventories')
                ->whereHas('applications', function ($query) use ($input) {
                    $query->whereHas('startings', function ($query) use ($input) {
                        $query->whereHas('progresses', function ($query) use ($input) {
                            $query->where('progress_id', '=' ,5);
                        });
                    });               
                    
                })
        ->get();

        } else {
            if (!empty($input['application_id'])) {

            $stations = Station::whereHas('applications', function ($query) use ($input) {
                    $query->where('id','=', $input['application_id'])                    
                    ->whereHas('startings', function ($query) use ($input) {
                        $query->whereHas('progresses', function ($query) use ($input) {

                            $query->where('progress_id', '=' ,5);
                        });
                    });               
                    
             })
        ->with('city', 'region','applications','applications.startings.progresses.inventories')
        
        ->get();
             } else {           
              
            if (!empty($input['area_id'])) {
            $stations = Station::where('area_id', $input['area_id'])                          
                ->whereHas('applications', function ($query) use ($input) {
                    $query->where('type_id', 1)->whereHas('startings', function ($query) use ($input) {
                        $query->whereHas('progresses', function ($query) use ($input) {
                            $query->where('progress_id', '=' ,5);
                        });
                    });               
                    
                })
        ->with('city', 'region','applications','applications.startings.progresses.inventories')
        ->get();
        } else {
            $stations = Station::whereHas('applications', function ($query) use ($input) {
                    $query->where('type_id', 1)->whereHas('startings', function ($query) use ($input) {
                        $query->whereHas('progresses', function ($query) use ($input) {
                            $query->where('progress_id', '=' ,5);
                        });
                    });               
                    
                })
            ->with('city', 'region','applications','applications.startings.progresses.inventories')
        ->get();
        } 
        }
        }
          //dd($stations) ;
       
        try {
        return Excel::download(new ActEquipmentInstallation($stations), 'act-equipment-installation.xlsx');
        } catch (Exception  $e) {
            return Excel::download($stations, 'act-equipment-installation.xlsx');
        }
    }

    public function actDischarge(ActDischargeRequest $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $input = $request->validated();
        $stations = Station::whereIn('id', $input['stations'])->where('area_id', $input['area_id'])->get();
        return Excel::download(new ActDischarge($stations), 'act-discharge.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
