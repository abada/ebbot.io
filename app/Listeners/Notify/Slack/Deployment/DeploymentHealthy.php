<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\Events\EbEnvironmentDeployHealthy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeploymentHealthy
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
     * @param  EbEnvironmentDeployHealthy  $event
     * @return void
     */
    public function handle(EbEnvironmentDeployHealthy $event)
    {
        //
    }
}
