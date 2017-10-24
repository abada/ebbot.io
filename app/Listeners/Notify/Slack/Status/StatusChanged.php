<?php

namespace App\Listeners\Notify\Slack\Status;

use App\BbNotifcation;
use App\Events\EbEnvironmentStatusChangeReported;
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
        'severe' => 'danger',
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
    public function handle(EbEnvironmentStatusChangeReported $event)
    {
        $environment = $event->environment;
        $status = $event->status;
        
        // CHECK SLACK ENABLED
        if(!$environment->notification_slack) {
            return;
        }
        
        // FETCH THE PREVIOUS STATUS
        $previousStatus = $environment->statuses()
            ->where('status_started_at', '<', $status->status_started_at)
            ->orderBy('status_started_at', 'DESC')
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
            'icon' => 'https://beanbot.io/img/beanbot.png',
        ]);
        
        $statusColor = $this->statusColorMap[strtolower($status->status)];
        
        
        $message = strtoupper($previousStatus->status).' -> '.strtoupper($status->status).': '.$environment->eb_environment.' ('.$environment->eb_application.') ';
        $message.= '<https://beanbot.io/home|Details>'; 
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
