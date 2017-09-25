<?php

namespace App\Libraries\SNSParser\Triggers\Deployment;

use App\Event;
use App\Event\EbEnvironmentDeployHealthy;
use App\Libraries\SNSParser\Trigger;
use App\Repositories\DeploymentRepository;
use App\Repositories\TeamRepository;

class DeploymentHealthy implements Trigger
{
    
    protected $teamRepo;
    protected $deploymentRepo;
    
    public function __construct() 
    {
        $this->teamRepo = new TeamRepository();
        $this->deploymentRepo = new DeploymentRepository();
    }
    
    public function shouldFire(Event $eb_event) 
    {
        return preg_match('/from Info to Ok. Application update completed/', $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // FETCH CONTEXT
        $team = $eb_event->team;
        $env = $this->teamRepo->persistEnvironmentForTeam($team, $eb_event->getEbApplication(), $eb_event->getEbEnvironment());
        
        // UPDATE DEPLOYMENT COMPLETE STATUS
        // only if its not already set
        $deployment = $this->deploymentRepo->getLastDeploymentForEbEnvironment($env);
        if(is_null($deployment->deployment_healthy_at)) {
            $deployment->deployment_healthy_at = $eb_event->getEbTimestamp();
            $deployment->save();
        }
        
        // FIRE DEPLOYMENT HEALTHY EVENT
        event(new EbEnvironmentDeployHealthy($deployment));
    }
    
}