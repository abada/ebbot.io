<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbEnvironmentDeployment extends Model
{
    
    public $dates = ['deployment_completed_at', 'deployment_healthy_at'];
    
    public function eb_environment() 
    {
        return $this->belongsTo('App\EbEnvironment');
    }
    
}
