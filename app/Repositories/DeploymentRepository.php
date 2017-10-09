<?php

namespace App\Repositories;

use App\EbEnvironment;
use Oefenweb\Statistics\Statistics;

class DeploymentRepository 
{

    public function getLastDeploymentForEbEnvironment(EbEnvironment $env)
    {
        return $env->deployments()->latest('created_at')->first();
    }
    
    public function getProjectedDeploymentDurationForEbEnvironment(EbEnvironment $env)
    {
        $durations = $env->deployments()->orderBy('id', 'DESC')->limit(5)->pluck('duration')->toArray();
        
        // DETERMINE AVG & STDDEV
        $duration_avg = Statistics::mean($durations);
        $duration_stddev = Statistics::standardDeviation($durations);
        
        return $duration_avg + $duration_stddev;
    }
    
}