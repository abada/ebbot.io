<?php

namespace App\Repositories;

use App\EbEnvironment;
use Carbon\Carbon;
use Oefenweb\Statistics\Statistics;

class DeploymentRepository 
{

    public function getLastDeploymentForEbEnvironment(EbEnvironment $env)
    {
        return $env->deployments()->latest('created_at')->first();
    }
    
    public function getProjectedDeploymentDurationForEbEnvironment(EbEnvironment $env, Carbon $before = null)
    {
        $query = $env->deployments()->orderBy('id', 'DESC');
        if(!is_null($before)) {
            $query = $query->where('created_at', '<', $before);
        }
        $durations = $query->limit(5)->pluck('duration')->toArray();
        if(count($durations) < 2) {
            return null;
        }
        
        // DETERMINE AVG & STDDEV
        $duration_avg = Statistics::mean($durations);
        //$duration_stddev = Statistics::standardDeviation($durations);
        
        //return $duration_avg + $duration_stddev;
        return $duration_avg;
    }
    
}