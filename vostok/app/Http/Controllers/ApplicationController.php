<?php

namespace App\Http\Controllers;

use App\Actions\Applications\UpdateApplication;
use App\Http\Requests\ApplicationFilter;
use App\Http\Requests\ApplicationStore;
use App\Http\Requests\ApplicationUpdate;
use App\Http\Resources\ApplicationsResource;
use App\Models\Application;
use App\Models\Area;
use App\Models\Project;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use App\Models\Work;
use App\Services\MapBoxService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class ApplicationController extends Controller
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
        $applications = Application::with([
            'user:id,lastname,firstname',
            'engineer:id,lastname,firstname',
            'project',
            'stations',
            'routes',
            'type',
            'works',
            'status',
        ])->latest();
        if (!isset($input['statuses']) && !isset($input['status'])) {
            $applications->active();
        }
        $applications->filter($input);
        return Inertia::render('Applications/Index', [
            'applications' => new ApplicationsResource($applications->paginate()->appends($input)),
            'areas' => Area::all(),
            'statuses' => Status::all(),
            'works' => Work::all(),
            'projects' => Project::all(),
            'types' => Type::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Applications/Create', [
            'works' => Work::all(),
            'projects' => Project::all(),
            'types' => Type::all(),
            'statuses' => Status::all(),
            'areas' => Area::all(),
            'users' => User::whereHas('roles', function (Builder $query) {
                $query->whereIn('slug', [
                    'engineer',
                ]);
            })->active()->orderBy('lastname')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApplicationStore $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        $data['users'] = array_unique($data['users'], SORT_NUMERIC);
        Arr::forget($data['users'], Auth::id());
        $area = Area::with([
            'division.user'
        ])->find($data['area']);
        $application = new Application();
        $application->fill($data);
        if (isset($data['deadline_at'])) {
            $application->deadline_at = Carbon::parse($data['deadline_at'])->setTimezone('UTC');
        }
        $application->user()->associate($area->division->user_id);
        $application->dispatcher()->associate(Auth::id());
        $application->engineer()->associate($data['engineer']);
        $application->type()->associate($data['type']);
        $application->project()->associate($data['project']);
        $application->area()->associate($area);
        $application->division()->associate($area->division_id);
        if (isset($data['works'][0]) && is_array($data['works'])) {
            $application->work()->associate($data['works'][0]);
        }
        $application->save();
        if (isset($data['works']) && is_array($data['works'])) {
            $application->works()->attach($data['works']);
        }
        if ($request->filled('users')) {
            $application->users()->sync($data['users']);
        }
        if ($request->filled('stations')) {
            $application->stations()->sync($data['stations']);
        }
        $optimized = (new MapBoxService())->getOptimizedTrips(
            'mapbox/driving-traffic',
            array_merge(
                [
                    "{$application->area->location->getLng()},{$application->area->location->getLat()}"
                ],
                $application->stations->map(fn($station) => "{$station->location->getLng()},{$station->location->getLat()}")->toArray()
            )
        );
        $optimized = json_decode($optimized, true);
        foreach ($optimized['waypoints'] as $index => $item) {
            if ($item['waypoint_index'] !== 0) {
                $application->stations()->updateExistingPivot($application->stations[$item['waypoint_index'] - 1], [
                    'sort' => $index
                ]);
            }
        }
        $application->distance = $optimized['trips'][0]['distance'];
        $application->save();
        //        if ($application->user->one_signal_token !== null) {
        //            $application->user->notify(new \App\Notifications\ApplicationStore($application));
        //        }
        //        if ($application->engineer !== null && $application->engineer->one_signal_token !== null) {
        //            $application->engineer->notify(new \App\Notifications\ApplicationStore($application));
        //        }
        User::where('division_id', '=', $area->division_id)
            ->whereHas('roles', function (Builder $query) {
                $query->whereIn('slug', [
                    'head.division',
                    'engineer'
                ]);
            })
            ->whereNotNull('one_signal_token')
            ->get()
            ->each(fn(User $user) => $user->notify(new \App\Notifications\ApplicationStore($application)));
        return redirect()->route('application.show', $application);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Application $application
     * @return \Inertia\Response
     */
    public function show(Application $application): \Inertia\Response
    {

        $application->load([
            'user:id,lastname,firstname',
            'users:id,lastname,firstname',
            'engineer:id,lastname,firstname',
            'area',
            'project',
            'startings',
            'startings.type',
            'startings.user',
            'startings.station:id,bts_id,location',
            'startings.progresses',
            'startings.progresses.typeable',
            'startings.progresses.typeable.modelable',
            'startings.progresses.progress',
            'startings.progresses.inventories',
            'startings.progresses.images',
            'startings.progresses.works',
            'startings.progresses.step',
            'type',
            'works',
            'routes',
            'stations',
            'comments',
            'comments.user',
            'status',
            'statuses',
            'statuses.pivot.user:id,lastname,firstname',
            'statuses.pivot.old_status',
            'accepts',
            'accepts.user:id,lastname,firstname',
            'accepts.users:id,lastname,firstname',
            'applicationReport',
            'applicationReport.images',
            'applicationReport.engineer',
            'applicationReport.works',
        ]);
        return Inertia::render('Applications/Show', [
            'application' => $application,
            'works' => Work::all(),
            'projects' => Project::all(),
            'types' => Type::all(),
            'users' => User::whereHas('roles', function (Builder $query) {
                $query->whereIn('slug', [
                    'engineer',
                ]);
            })->active()->orderBy('lastname')->get(),
            'statuses' => Status::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplicationUpdate $request
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplicationUpdate $request, Application $application): \Illuminate\Http\RedirectResponse
    {
        (new UpdateApplication())->update($application, $request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
}
