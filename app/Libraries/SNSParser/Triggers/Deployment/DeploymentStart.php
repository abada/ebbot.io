<?php

namespace App\Libraries\SNSParser\Triggers\Deployment;

use App\Event;
use App\EbEnvironmentDeployment;
use App\Libraries\SNSParser\Trigger;
use App\Repositories\TeamRepository;

class DeploymentStart implements Trigger
{
    
    protected $teamRepo;
    
    public function __construct() 
    {
        $this->teamRepo = new TeamRepository();
    }
    
    public function shouldFire(Event $eb_event) 
    {
        return preg_match('/Application update in progress on [0-9]+ instance(s)?. [0-9]+ out of [0-9]+ instances completed/', $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // FETCH CONTEXT
        $team = $eb_event->team;
        $env = $this->teamRepo->persistEnvironmentForTeam($team, $eb_event->getEbApplication(), $eb_event->getEbEnvironment());
        
        // CREATE AND SAVE DEPLOYMENT
        $deployment = new EbEnvironmentDeployment;
        $deployment->created_at = $eb_event->getEbTimestamp();
        $env->deployments()->save($deployment);
        
        // FIRE NEW DEPLOYMENT EVENT
        // @JonasTODO: Implement This
    }
    
}