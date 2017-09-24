<?php

namespace App\Repositories;

use App\EbEnvironment;

class DeploymentRepository 
{

    public function getLastDeploymentForEbEnvironment(EbEnvironment $env)
    {
        return $env->deployments()->latest('created_at')->first();
    }
    
}