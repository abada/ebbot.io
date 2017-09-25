<?php 

namespace App\Libraries\SNSParser;

use App\Event;
use Log;

use App\Libraries\SNSParser\Triggers\Deployment\DeploymentStart;
use App\Libraries\SNSParser\Triggers\Deployment\DeploymentComplete;
use App\Libraries\SNSParser\Triggers\Deployment\DeploymentHealthy;
use App\Libraries\SNSParser\Triggers\Status\StatusChange;

class SNSParser {
    
    protected $triggers = [
        
        // DEPLOYMENTS
        DeploymentStart::class,
        DeploymentComplete::class,
        DeploymentHealthy::class,
        
        // STATUS
        StatusChange::class,
        
    ];
    
    public function parse(Event $eb_event) 
    {
        $success = 0;
        
        if($eb_event->isEbNotification()) {
            
            $eb_message = $eb_event->getEbMessage();
            
            
            // REGEXT MATCH DETECTED
            // should now process all registered triggers
            foreach($this->triggers as $trigger) 
            {
                try 
                {
                    // ATTEMPT TO PROCESS THE TRIGGER
                    // may modify database states
                    $instance = new $trigger();
                    if($instance->shouldFire($eb_event)) 
                    {
                        $instance->fire($eb_event);
                         $success ++;
                    }
                    
                }
                catch(\Exception $e) 
                {
                    // REPORT EXCEPTION
                    // allow the remaining triggers to process
                    Log::error($e, [
                        'event_id' => $eb_event->id,
                        'trigger' => $trigger,
                    ]);
                }
            }
        }
        
        return $success;
    }
    
}