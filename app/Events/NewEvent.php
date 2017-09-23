<?php

namespace App\Events;

use App\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eb_event;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $eb_event)
    {
        $this->eb_event = $eb_event;
    }

}
