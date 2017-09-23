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
        
        // EXTRACT PAYLOAD
        $payload = json_decode($eb_event->payload);
        
        // PARSE SNS MESSAGE
        $eb = [
            'timestamp' => null,
            'message' => null,
            'environment' => null,
            'application' => null,
            'environment_url' => null,
            'notificationprocessid' => null,
        ];
        $rows = explode("\n", $payload->Message);
        foreach($rows as $row) 
        {
            $components = explode(':', $row, 2);
            if(count($components) == 2) {
                
                $key = trim(strtolower(str_replace(' ', '_', $components[0])));
                
                if($key == 'timestamp') 
                {
                    $value = new Carbon(trim($components[1]));
                }
                else 
                {
                    $value = trim($components[1]);    
                }
            
                
                $eb[$key] = $value;
            }
        }
        
        $eb_environment = $team->ebenvironments()
            ->where('eb_application', $eb['application'])
            ->where('eb_environment', $eb['environment'])
            ->first();
            
        if(is_null($eb_environment)) {
            $env = new EbEnvironment;
            $env->eb_application = $eb['application'];
            $env->eb_environment = $eb['environment'];
            $team->ebenvironments()->save($env);
        }
        
        
        
    }
}
