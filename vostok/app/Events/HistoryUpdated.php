<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class HistoryUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $logMagazine;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($logMagazine)
    {

        $this->logMagazine = $logMagazine;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('history');
    }
}
