<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\Events\EbEnvironmentDeployHealthy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maknz\Slack\Client as SlackClient;

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
        
        $environment = $event->environment;
        $deploy = $event->deploy;
        
        // CHECK SLACK ENABLED
        if(!$environment->notification_slack) {
            return;
        }
        
        // CHECK WETHER OR NOT TO NOTIFY
        if(!$environment->notify_deployment_healthy) {
            return;
        }
        
        $slack = new SlackClient($environment->notification_slack_hook, [
            'username' => 'BeanBot',
            'channel' => $environment->notification_slack_channel,
            'icon' => ':robot_face:',
        ]);
        
        $duration_str = $deploy->created_at->diffForHumans($deploy->deployment_completed_at, true);
        $healthy_str = $deploy->created_at->diffForHumans($deploy->deployment_healthy_at, true);
        
        $slack->attach(
            [
            	'fallback' => 'Deploy healthy for '.$environment->eb_environment.'.',
            	'text' => 'Deploy healthy for '.$environment->eb_environment.'.',
            	'color' => 'good',
            	'fields' => [
            		[
            			'title' => 'Duration',
            			'value' => $duration_str,
            			'short' => true
            		],
            		[
            			'title' => 'Healthy After',
            			'value' => $healthy_str,
            			'short' => true
            		],
            	]
            ])->send();
    }
}
