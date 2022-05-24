<?php

namespace App\Events;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ApplicationResource|Application
     */
    public $application;

    /**
     * Create a new event instance.
     *
     * @param ApplicationResource|Application $application
     */
    public function __construct($application)
    {
        $this->application = new ApplicationResource($application->load([
            'user:id,lastname,firstname',
            'users:id,lastname,firstname',
            'engineer:id,lastname,firstname',
            'area',
            'project',
            'startings',
            'startings.user',
            'startings.station:id,bts_id,location',
            'startings.progresses',
            'startings.progresses.progress',
            'startings.progresses.inventories',
            'startings.progresses.images',
            'startings.progresses.works',
            'type',
            'works',
            'routes',
            'stations',
            'images:id,path',
            'comments:id,comment',
            'status',
            'statuses',
            'statuses.pivot.user:id,lastname,firstname',
            'statuses.pivot.old_status',
            'accepts',
            'accepts.user:id,lastname,firstname',
            'accepts.users:id,lastname,firstname',
        ]));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("application.{$this->application->id}");
    }
}
