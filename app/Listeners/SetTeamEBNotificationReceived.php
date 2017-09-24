<?php

namespace App\Listeners;

use App\Events\NewEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class SetTeamEBNotificationReceived
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
     * @param  NewEvent  $event
     * @return void
     */
    public function handle(NewEvent $event)
    {
        $eb_event = $event->eb_event;
        $team = $eb_event->team;
        
        if(!is_null($team->sns_eb_received_at)) {
            return true;
        }
        
        if($eb_event->isEbNotification()) {
            
            if(is_null($team->sns_subscribed_at)) {
                $team->sns_subscribed_at = Carbon::now();
            }
            
            $team->sns_eb_received_at = Carbon::now();
            $team->save();
            
        }
        
        
    }
}
