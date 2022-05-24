<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\PrioritiesResource;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ApplicationFilter $request
     * @return PrioritiesResource
     */
    public function __invoke(ApplicationFilter $request): PrioritiesResource
    {
        $input = $request->validated();
        $user = Auth::user();
        $applications = Application::select('priority')
            ->selectRaw('count(*) as applications_count')
            ->filter($input)
            ->groupBy('priority');
        if (!$user->hasPermission('index.applications')) {
            $applications->where('division_id', '=', $user->division_id);
        }
        return new PrioritiesResource($applications->get());
    }
}
