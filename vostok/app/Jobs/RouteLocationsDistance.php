<?php

namespace App\Jobs;

use App\Events\RouteUpdated;
use App\Models\Route;
use App\Services\MapBoxService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RouteLocationsDistance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Route
     */
    private Route $route;

    /**
     * Create a new job instance.
     *
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        //
        $this->route = $route;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $distance = 0;
        $locations = $this->route->locations->chunk(24);
        try {
            foreach ($locations as $key => $item) {
                if ($key !== 0) {
                    $last = $locations[$key - 1]->last();
                    Log::info('Log: ', $last->toArray());
                    $item->prepend($last);
                }
                $response = (new MapBoxService())->getDirectionDriving(
                    $item
                        ->map(fn($item) => "{$item->location->getLng()},{$item->location->getLat()}")
                        ->toArray()
                );
                $distance += $response['routes'][0]['distance'];
            }
        } catch (\Exception $exception) {
            Log::error("Route ID {$this->route->id}. MapBox error: {$exception->getMessage()}");
            return;
        }

        $this->route->actual_distance = $distance;
        $this->route->save();
        broadcast(new RouteUpdated($this->route));
    }
}
