<?php

namespace App\Events;

use App\Http\Resources\RouteLocationsResource;
use App\Models\Route;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RouteLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var RouteLocationsResource
     */
    public RouteLocationsResource $collection;
    /**
     * @var Route
     */
    private Route $route;

    /**
     * Create a new event instance.
     *
     * @param Collection $collection
     */
    public function __construct(Route $route, Collection $collection)
    {
        $this->collection = new RouteLocationsResource($collection);
        $this->route = $route;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("route.{$this->route->id}");
    }
}
