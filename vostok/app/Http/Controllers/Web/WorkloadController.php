<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\WorkloadsResource;
use App\Models\Application;

class WorkloadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ApplicationFilter $request
     * @return WorkloadsResource
     */
    public function __invoke(ApplicationFilter $request): WorkloadsResource
    {
        $input = $request->validated();
        $applications = Application::selectRaw('DATE(`deadline_at`) as deadline_at, count(*) as applications_count')
            ->whereIn('status_id', [
                1, 2, 3
            ])
            ->filter($input)
            ->orderByDesc('applications_count')
            ->groupByRaw("DATE(`deadline_at`)")
            ->limit(10);
        if (!isset($input['created_from'], $input['created_to'])) {
            $applications->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ]);
        }
        return new WorkloadsResource($applications->get());
    }
}
