<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbEnvironment extends Model
{
    
    public function team() 
    {
        return $this->belongsTo('App\Team');
    }
    
    public function status() 
    {
        return $this->hasOne('App\EbEnvironmentStatus')->latest('id');
    }
    
    public function statuses() 
    {
        return $this->hasMany('App\EbEnvironmentStatus');
    }
    
    public function deployments() {
        return $this->hasMany('App\EbEnvironmentDeployment');
    }
    
    public function last_deployment() 
    {
        return $this->hasOne('App\EbEnvironmentDeployment')->latest('id');
    }
}
