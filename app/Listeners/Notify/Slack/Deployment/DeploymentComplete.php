<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\Events\EbEnvironmentDeployCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeploymentComplete
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
     * @param  EbEnvironmentDeployCompleted  $event
     * @return void
     */
    public function handle(EbEnvironmentDeployCompleted $event)
    {
        //
    }
}
