<?php

namespace App\Listeners\Notify\Slack\Deployment;

use App\BbNotifcation;
use App\Events\EbEnvironmentDeployCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maknz\Slack\Client as SlackClient;

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
        
        $environment = $event->environment;
        $deploy = $event->deploy;
        
        // CHECK SLACK ENABLED
        if(!$environment->notification_slack) {
            return;
        }
        
        // CHECK WETHER OR NOT TO NOTIFY
        if(!$environment->notify_deployment_complete) {
            return;
        }
        
        $slack = new SlackClient($environment->notification_slack_hook, [
            'username' => 'BeanBot',
            'channel' => $environment->notification_slack_channel,
            'icon' => ':robot_face:',
        ]);
        
        $duration_str = $deploy->created_at->diffForHumans($deploy->deployment_completed_at, true);
        $message = 'Deploy finished for '.$environment->eb_environment.'.';
        $attachment = [
        	'fallback' => $message,
        	'text' => $message,
        	'color' => 'good',
        	'fields' => [
        		[
        			'title' => 'Duration',
        			'value' => $duration_str,
        			'short' => true
        		],
        	]
        ];
        
        $slack->attach($attachment)->send();
            
        // SAVE NOTIFICATION
        $bbNotification = new BbNotifcation;
        $bbNotification->team_id = $environment->team_id;
        $bbNotification->platform = 'slack';
        $bbNotification->message = $message;
        $bbNotification->attachment = json_encode($attachment);
        $bbNotification->notifiable()->associate($deploy);
        $bbNotification->save();
    }
}
