<?php

namespace App\Libraries\SNSParser\Triggers\Status;

use App\Event;
use App\Events\EbEnvironmentStatusChanged;
use App\EbEnvironmentStatus;
use App\Libraries\SNSParser\Trigger;
use App\Repositories\TeamRepository;

class StatusChange implements Trigger
{
    
    protected $teamRepo;
    
    public function __construct() 
    {
        $this->teamRepo = new TeamRepository();
    }
    
    public function shouldFire(Event $eb_event) 
    {
        return preg_match('/Environment health has transitioned from [A-Za-z]+ to [A-Za-z]+./', $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // FETCH CONTEXT
        $team = $eb_event->team;
        $env = $this->teamRepo->persistEnvironmentForTeam($team, $eb_event->getEbApplication(), $eb_event->getEbEnvironment());
        
        // GET ENVIRONMENT STATE FROM MESSAGE
        preg_match('/transitioned from ([A-z]+) to ([A-z]+)./', $eb_event->getEbMessage(), $matches);
        $from = $matches[1];
        $to = $matches[2];
        
        // // CHECK IF ENVIRONMENT STATE ALREADY CURRENT
        if(!is_null($env->status) && $env->status->status == $to) {
            return true;
        }
        
        // CREATE NEW ENVIRONMENT STATUS
        $status = new EbEnvironmentStatus;
        $status->status = $to;
        $status->status_set_at = $eb_event->getEbTimestamp();
        $env->statuses()->save($status);
        
        // FIRE NEW ENVIRONMENT STATUS EVENT
        event(new EbEnvironmentStatusChanged($env->status));
    }
    
}