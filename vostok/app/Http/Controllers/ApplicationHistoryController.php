<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\ApplicationsResource;
use App\Http\Resources\StatusesResource;
use App\Models\Application;
use App\Models\Status;
use Inertia\Inertia;

class ApplicationHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function __invoke(ApplicationFilter $request): \Inertia\Response
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
        ])
            ->latest('updated_at')
            ->whereIn('status_id', [
                7, 8
            ]);
        $applications->filter($input);
        $statuses = Status::whereIn('id', [7, 8])->get();
        return Inertia::render('Applications/History', [
            'applications' => new ApplicationsResource($applications->paginate()->appends($input)),
            'statuses' => new StatusesResource($statuses)
        ]);
    }
}
