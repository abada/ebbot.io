<?php

namespace App\Listeners\Notify\Slack\Status;

use App\BbNotifcation;
use App\Events\EbEnvironmentStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maknz\Slack\Client as SlackClient;

class StatusChanged
{
    
    protected $statusColorMap = [
        'ok' => 'good',
        'info' => 'good',
        'unkown' => 'warning',
        'warning' => 'warning',
        'degraded' => 'danger',
        'severe' => 'severe',
    ];
    
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
     * @param  EbEnvironmentStatusChanged  $event
     * @return void
     */
    public function handle(EbEnvironmentStatusChanged $event)
    {
        $environment = $event->environment;
        $status = $event->status;
        
        // CHECK SLACK ENABLED
        if(!$environment->notification_slack) {
            return;
        }
        
        // FETCH THE PREVIOUS STATUS
        $previousStatus = $environment->statuses()
            ->where('status_set_at', '<', $status->status_set_at)
            ->orderBy('status_set_at', 'DESC')
            ->first();
            
        // SKIP IF THERE IS NO PREVIOUS STATUS
        if(is_null($previousStatus)) {
            return;
        }
            
        // CHECK WHETER TO MUTE THIS NOTIFICATION
        $currentStatusField = 'notify_status_'.strtolower($status->status);
        $notifyForCurrentStatus = $environment->$currentStatusField;
        $previousStatusField = 'notify_status_'.strtolower($previousStatus->status);
        $notifyForPreviousStatus = $environment->$previousStatusField;
        if(!$notifyForPreviousStatus && !$notifyForCurrentStatus) {
            return;
        }
        
        // SEND THE SLACK NOTIFICATION
        $slack = new SlackClient($environment->notification_slack_hook, [
            'username' => 'BeanBot',
            'channel' => $environment->notification_slack_channel,
            'icon' => ':robot_face:',
        ]);
        
        $statusColor = $this->statusColorMap[strtolower($status->status)];
        
        
        $message = strtoupper($status->status).': '.$environment->eb_application.' - '.$environment->eb_environment.'. ';
        $message.= '[More Details](https://beanbot.io/home)'; 
        $attachment = [
        	'fallback' => $message,
        	'text' => $message,
        	'color' => $notifyForCurrentStatus ? $statusColor : 'good',
        	'fields' => [],
        ];
        
        $slack->attach($attachment)->send();
            
        // SAVE NOTIFICATION
        $bbNotification = new BbNotifcation;
        $bbNotification->team_id = $environment->team_id;
        $bbNotification->platform = 'slack';
        $bbNotification->message = $message;
        $bbNotification->attachment = json_encode($attachment);
        $bbNotification->notifiable()->associate($status);
        $bbNotification->save();
        
        
    }
}
