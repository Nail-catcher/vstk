<?php


namespace App\Actions\Routes;

use App\Models\Area;
use App\Models\Consumable;
use App\Models\Route;
use App\Services\MapBoxService;
use App\Settings\GeneralSettings;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateNewRoute
{
    /**
     * @param array $input
     * @return Route
     */
    public function create(array $input): Route
    {
        $area = Area::find($input['area']);
        $route = new Route();
        if (isset($input['deadline_at'])) {
            $route->deadline_at = Carbon::parse($input['deadline_at'])->setTimezone('UTC');
        }
        if (isset($input['started_at'])) {
            $route->started_at =   Carbon::parse($input['started_at'])->setTimezone('UTC');
        }
        if (!isset($input['engineer'])) {
            $input['engineer'] = Auth::id();
        }
        $route->user()->associate(\Auth::user());
        $route->engineer()->associate($input['engineer']);
        if ($input['vehicle_type']){
        $route->vehicle_type()->associate($input['vehicle_type']);
        }
        if(isset($input['vehicle'])){
        $route->vehicle()->associate($input['vehicle']);
        }
        $route->area()->associate($area);
        $route->division()->associate($area->division_id);
        $route->save();
        $route->applications()->attach($input['applications']);

        $application = $route->applications()->first();
        $users = array_unique($application->users()->pluck('id')->toArray(), SORT_NUMERIC);
        Arr::forget($users, $input['engineer']);
        $route->users()->attach($users);

        $stations = collect();
        $route->applications->each(fn($application) => $stations->push($application->stations()->first()));

        $optimized = (new MapBoxService())->getOptimizedTrips(
            'mapbox/driving-traffic',
            array_merge(
                $stations->map(fn($station) => "{$station->location->getLng()},{$station->location->getLat()}")->toArray(),
                $route->addresses->map(fn($address) => "{$address->location->getLng()},{$address->location->getLat()}")->toArray()
            )
    );

        $optimized = json_decode($optimized, true);
//        foreach ($optimized['waypoints'] as $index => $item) {
//            if ($item['waypoint_index'] !== 0) {
//                $route->applications()->updateExistingPivot($route->applications[$item['waypoint_index'] - 1], [
//                    'sort' => $index
//                ]);
//            }
//        }

        if (isset($input['addresses']) && is_array($input['addresses'])) {
            $route->addresses()->attach($input['addresses']);
        }
        if (isset($input['places']) && is_array($input['places'])) {
            $route->places()->attach($input['places']);
        }
        if (isset($input['consumables']) && is_array($input['consumables'])) {
            foreach ($input['consumables'] as $consumable) {
                $route->consumables()->attach($consumable['id'], [
                    'count' => $consumable['count']
                ]);
            }
        }
        $route = $this->expenses($route, $stations, $application->area);
        $route->save();

        $route->engineer->notify(new \App\Notifications\RouteCreated($route));

        $route->users->each(fn($user) => $user->notify(new \App\Notifications\RouteCreated($route)));

        return $route;
    }

    /**
     * @param Route $route
     * @return Route
     */
    public function expenses(Route $route, $area): Route
    {
        $stations = collect();
        $route->applications->each(fn($application) => $application->stations()->each(fn($station) => $stations->push($station)));
        $locations = array_merge(
            [
                "{$route->area->location->getLng()},{$route->area->location->getLat()}"
            ],
            $stations->map(fn($station) => "{$station->location->getLng()},{$station->location->getLat()}")->toArray(),
            $route->addresses->map(fn($station) => "{$station->location->getLng()},{$station->location->getLat()}")->toArray(),
            $route->places->map(fn($place) => "{$place->location->getLng()},{$place->location->getLat()}")->toArray(),
            ["{$route->area->location->getLng()},{$route->area->location->getLat()}"]
        );
        $optimized = (new MapBoxService())->getOptimizedTrips(
            'mapbox/driving-traffic',
            $locations
        );
        $optimized = json_decode($optimized, true);
        if ($optimized['trips'][0]['distance']!=null){
        $route->distance = $optimized['trips'][0]['distance'];
        } else {
            $route->distance = 0.00;
        }
        $settings = app(GeneralSettings::class);

        $started_at = $route->started_at;
        $deadline_at = $route->deadline_at;
        $days = round($started_at->startOfDay()->floatDiffInDays($deadline_at->endOfDay()), 0);
        if ($days > 1) {
            $route->travel_costs = ($days * ($settings->monthly_calculation_index * 2)) * ($route->users()->count() + 1);
            $route->overnight_costs = optional($route->addresses()->first())->cost * ($route->started_at->startOfDay()->diffInDays($route->deadline_at)) * ($route->users()->count() + 1);
        }
        $start_winter = (new Carbon())->setMonth(12)->startOfMonth();
        $end_winter = (new Carbon())->setMonth(2)->endOfMonth();
        if ($route->vehicle){
        $fuels_costs = $route->vehicle->summer;
        if ($route->started_at > $start_winter && $route->started_at < $end_winter) {
            $fuels_costs = $route->vehicle->winter;
        }
        $route->fuels = $fuels_costs * (($route->distance / 1000) / 100);

        $route->fuel_costs = $route->division->gasoline_cost * $route->fuels;
        $route->material_costs = 0;
        $route->consumables->each(function (Consumable $consumable) use ($route) {
            $route->material_costs += $consumable->cost * $consumable->pivot->count;
        });
        $route->expenses = $route->travel_costs + $route->fuel_costs + $route->overnight_costs + $route->material_costs;
        }
        return $route;
    }
}
