<?php

namespace App\Events;

use App\EbEnvironmentDeployment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EbEnvironmentDeployCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $deploy;
    public $environment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EbEnvironmentDeployment $deploy)
    {
        $this->deploy = $deploy;
        $this->environment = $deploy->eb_environment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('team.'.$this->environment->team_id);
    }
    
    public function broadcastWith()
    {
        return [
            'eb_application' => $this->environment->eb_application,
            'eb_environment' => $this->environment->eb_environment,
            'deployment' => $this->deploy
        ];
    }
}
