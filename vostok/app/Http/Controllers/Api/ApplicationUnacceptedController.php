<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\ApplicationsResource;
use App\Models\Application;

class ApplicationUnacceptedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ApplicationFilter $request
     * @return ApplicationsResource
     */
    public function __invoke(ApplicationFilter $request): ApplicationsResource
    {
        $input = $request->validated();
        $applications = Application::with([
            'type',
            'works',
            'status'
        ])
            ->where('attempts', '>', 0);
        $applications->filter($input);
        return new ApplicationsResource($applications->paginate($data['limit'] ?? null)->appends($input));
    }
}
