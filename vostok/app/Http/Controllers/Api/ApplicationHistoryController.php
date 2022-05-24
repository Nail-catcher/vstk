<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\ApplicationsResource;
use App\Models\Application;

class ApplicationHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ApplicationFilter $request
     * @return ApplicationsResource
     */
    public function __invoke(ApplicationFilter $request)
    {
        $input = $request->validated();
        $applications = Application::with(['user', 'area', 'project', 'stations', 'type', 'work', 'works', 'status'])
            ->filter($input)
            ->whereIn('status_id', [4, 7, 8])
            ->latest('updated_at');
        return new ApplicationsResource($applications->paginate($input['limit'] ?? null)->appends($input));
    }
}
