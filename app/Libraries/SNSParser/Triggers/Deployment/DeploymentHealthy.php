<?php

namespace App\Libraries\SNSParser\Triggers\Deployment;

use App\Event;
use App\Libraries\SNSParser\Trigger;

class DeploymentHealthy implements Trigger
{
    
    public function shouldFire(Event $eb_event) 
    {
        return preg_match('/from Info to Ok. Application update completed/', $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // @JonasTODO: Implement This
        var_dump('deployment_healthy');
    }
    
}