<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\Events\EbEnvironmentDeployStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maknz\Slack\Client as SlackClient;

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

        $environment = $event->environment;
        $deploy = $event->deploy;
        
        // CHECK SLACK ENABLED
        if(!$environment->notification_slack) {
            return;
        }
        
        // CHECK WETHER OR NOT TO NOTIFY
        if(!$environment->notify_deployment_start) {
            return;
        }
        
        $slack = new SlackClient($environment->notification_slack_hook, [
            'username' => 'BeanBot',
            'channel' => $environment->notification_slack_channel,
            'icon' => ':robot_face:',
        ]);
        
        $started_str = $deploy->created_at->diffForHumans(null, true);
        
        $slack->attach(
            [
            	'fallback' => 'Deploy running for '.$environment->eb_environment.'.',
            	'text' => 'Deploy running for '.$environment->eb_environment.'.',
            	'color' => 'warning',
            	'fields' => []
        	])->send();
        
    }
}
