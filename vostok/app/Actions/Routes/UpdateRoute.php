<?php


namespace App\Actions\Routes;


use App\Events\RouteUpdated;
use App\Models\Activity;
use App\Models\Route;
use App\Models\RouteClosure;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class UpdateRoute
{
    /**
     * @param Route $route
     * @param array $input
     * @return Route
     */
    public function update(Route $route, array $input): Route
    {

        if (isset($input['applications']) && is_array($input['applications'])) {
            $route->applications()->sync($input['applications']);
        }
        if (isset($input['deadline_at'])) {
            $route->deadline_at = Carbon::parse($input['deadline_at'])->setTimezone('UTC');
        }
        if (isset($input['started_at'])) {
            $route->started_at = Carbon::parse($input['started_at'])->setTimezone('UTC');
        }
        if (isset($input['engineer'])) {
            $route->engineer()->associate($input['engineer']);
        }
        if (!empty($input['users'])) {
            $input['users'] = array_unique($input['users'], SORT_NUMERIC);
            Arr::forget($input['users'], $input['engineer']);
            $route->users()->sync($input['users']);
        }
        if (isset($input['activity'])) {
            $route->activity()->associate($input['activity']);

        }
        $route = (new CreateNewRoute())->expenses($route, $route->area);
        broadcast(new RouteUpdated($route))->toOthers();
        $route->save();
        return $route;
    }

    /**
     * @param Route $route
     * @param array $input
     * @return Route
     */
    public function closed(Route $route, array $input): Route
    {
        $route->activity()->associate(Activity::CLOSED);
        $closure = new RouteClosure([
            'comment' => $input['comment']
        ]);
        $closure->route()->associate($route);
        $closure->user()->associate(\Auth::user());
        $closure->save();
        $route->save();
        broadcast(new RouteUpdated($route))->toOthers();
        return $route;
    }

}
