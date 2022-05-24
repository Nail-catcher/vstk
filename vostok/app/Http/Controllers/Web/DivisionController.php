<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionsResource;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $divisions = Division::withCount([
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
            $divisions->where('id', '=', $user->division_id);
        }
        return new DivisionsResource($divisions->get());
    }
}
