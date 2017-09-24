<?php

namespace App\Libraries\SNSParser\Triggers\Deployment;

use App\Event;
use App\Libraries\SNSParser\Trigger;

class DeploymentStart implements Trigger
{
    
    public function shouldFire(Event $eb_event) 
    {
        return preg_match('/Application update in progress on [0-9]+ instance(s)?. [0-9]+ out of [0-9]+ instances completed/', $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // @JonasTODO: Implement This
        var_dump('deployment_start');
    }
    
}