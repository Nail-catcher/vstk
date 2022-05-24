<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\StatusesResource;
use App\Models\Area;
use App\Models\Status;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function __invoke(ApplicationFilter $request)
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
        return Inertia::render('Dashboard', [
            'areas' => $areas,
            'statuses' => new StatusesResource(Status::all())
        ]);
    }
}
