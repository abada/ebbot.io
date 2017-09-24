<?php

namespace App\Repositories;

use App\Team;
use App\EbEnvironment;

class TeamRepository 
{
    
    /**
     * returns the EbEnvironment instance for the team based on the eb ids
     *
     * @param App\Team $team the team to get the eb environment instance for
     * @param $eb_app string|null the eb application name 
     * @param $eb_env string the name for the eb environment
     * @return App\EbEnbironment|null the environment instance for the team's parameters
     */
    public function getEnvironmentForTeam(Team $team, $eb_app = null, $eb_env)
    {
        $envQuery = $team->ebenvironments()
            ->where('eb_environment', $eb_env);
        if(!is_null($eb_app)) {
            $envQuery = $envQuery->where('eb_application', $eb_app);
        } 
        return $envQuery->first();
        
    }
    
    /**
     * returns the EbEnvironment instance for the team based on the eb ids
     * should the environment not exist, it is created on the fly
     *
     * @param App\Team $team the team to get the eb environment instance for
     * @param $eb_app string|null the eb application name 
     * @param $eb_env string the name for the eb environment
     * @return App\EbEnbironment the environment instance for the team's parameters
     */
    public function persistEnvironmentForTeam(Team $team, $eb_app = null, $eb_env)
    {
        $env = $this->getEnvironmentForTeam($team, $eb_app, $eb_env);
        if(is_null($env))
        {
    
            $env = new EbEnvironment;
            $env->eb_application = $eb_app;
            $env->eb_environment = $eb_env;
            $team->ebenvironments()->save($env);
            
        }
    
        return $env;
    }
    
}