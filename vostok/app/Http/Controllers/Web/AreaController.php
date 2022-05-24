<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\AreasResource;
use App\ModelFilters\ApplicationFilter;
use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\ModelFilters\ApplicationFilter $request
     * @return AreasResource
     */
    public function __invoke(ApplicationFilter $request): AreasResource
    {
        $user = Auth::user();
        $areas = Area::withCount([
            'applications' => function (Builder $query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->created_from ? (new Carbon($request->created_from)) : now()->startOfMonth(),
                    $request->created_to ? (new Carbon($request->created_to)) : now()->endOfMonth(),
                ]);
                if ($request->filled('types')) {
                    $query->whereIn('type_id', $request->types);
                }
            }
        ]);
        if (!$user->hasPermission('index.applications')) {
            $areas->where('division_id', '=', $user->division_id);
        }
        return new AreasResource($areas->get());
    }
}
