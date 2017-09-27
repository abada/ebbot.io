<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\Events\EbEnvironmentDeployStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeploymentStart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EbEnvironmentDeployStarted  $event
     * @return void
     */
    public function handle(EbEnvironmentDeployStarted $event)
    {
        //
    }
}
