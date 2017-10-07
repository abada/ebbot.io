<?php

namespace App\Libraries\SNSParser\Triggers\Deployment;

use App\Event;
use App\Events\EbEnvironmentDeployCompleted;
use App\Libraries\SNSParser\Trigger;
use App\Repositories\DeploymentRepository;
use App\Repositories\TeamRepository;

class DeploymentComplete implements Trigger
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
        return preg_match("/New application version was deployed/", $eb_event->getEbMessage());
    }
    
    public function fire(Event $eb_event) 
    {
        // FETCH CONTEXT
        $team = $eb_event->team;
        $env = $this->teamRepo->persistEnvironmentForTeam($team, $eb_event->getEbApplication(), $eb_event->getEbEnvironment());
        
        // UPDATE DEPLOYMENT COMPLETE STATUS
        // only if its not already set
        $deployment = $this->deploymentRepo->getLastDeploymentForEbEnvironment($env);
        if(is_null($deployment->deployment_completed_at)) {
            $deployment->deployment_completed_at = $eb_event->getEbTimestamp();
            $deployment->duration = $deployment->created_at->diffInSeconds($deployment->deployment_completed_at);
            $deployment->save();
        }
        
        // FIRE DEPLOYMENT COMPLETE EVENT
        event(new EbEnvironmentDeployCompleted($deployment));
    }
    
}