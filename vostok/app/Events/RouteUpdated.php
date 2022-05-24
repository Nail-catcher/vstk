<?php

namespace App\Events;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RouteUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Route
     */
    public $route;

    /**
     * Create a new event instance.
     *
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        //
        $this->route = new RouteResource($route->load([
            'user',
            'activity',
            'applications',
            'applications.stations',
            'applications.type',
            'applications.work',
            'applications.works'
        ]));
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
