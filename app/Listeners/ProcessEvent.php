<?php

namespace App\Listeners;

use App\Events\NewEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use App\EbEnvironment;

class ProcessEvent
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
        
        $eb_environment = $team->ebenvironments()
            ->where('eb_application', $eb_event->getEbApplication())
            ->where('eb_environment', $eb_event->getEbEnvironment())
            ->first();
            
        if(is_null($eb_environment)) {
            $env = new EbEnvironment;
            $env->eb_application = $eb_event->getEbApplication();
            $env->eb_environment = $eb_event->getEbEnvironment();
            $team->ebenvironments()->save($env);
        }
        
        
        
    }
}
