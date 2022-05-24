<?php


namespace App\Actions\Routes;

use App\Models\Application;
use App\Services\MapBoxService;

class CalculateRoute
{
    /**
     * @param array $input
     */
    public function calculate(array $input)
    {
        $applications = Application::whereIn('id', $input['applications'])->with(['stations', 'area'])->get();
        foreach ($applications as $application) {
            foreach ($application->stations as $station) {
                $optimized = (new MapBoxService())->getOptimizedTrips(
                    'mapbox/driving-traffic',
                    [
                        "{$application->area->location->getLng()},{$application->area->location->getLat()}",
                        "{$station->location->getLng()},{$station->location->getLat()}"
                    ],
                );
                $optimized = json_decode($optimized, true);
                $station->distance_from_user = $optimized['trips'][0]['distance'];
            }
            $application->stations = $application->stations->sortBy('distance_from_user');
        }
        // for($i = 1; $i < $applications->count(); ++$i) {
        //     $x = $applications[$i]->stations[0]->distance_from_user;
        //     $j = $i;
        //     while($j > 0 && $applications[$j - 1]->stations[0]->distance_from_user > $x) {
        //         $applications[$j] = $applications[$j - 1];
        //         --$j;
        //     }
        //     $applications[$j] = $applications[$i];
        // }
        return $applications;
    }
}
