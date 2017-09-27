<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbEnvironment extends Model
{
    
    public $fillable = [
        'notification_slack',
        'notification_slack_hook',
        'notification_slack_channel',
        
        'notify_deployment_start',
        'notify_deployment_complete',
        'notify_deployment_healthy',
        
        'notify_status_ok',
        'notify_status_info',
        'notify_status_unknown',
        'notify_status_warning',
        'notify_status_degraded',
        'notify_status_severe',
    ];
    
    public function team() 
    {
        return $this->belongsTo('App\Team');
    }
    
    public function status() 
    {
        return $this->hasOne('App\EbEnvironmentStatus')->latest('status_set_at');
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
    
    public function save(array $options = []) {
        // CALCULATE CUSTOM NUMBER FROM ATTRIBUTES
        $arr = $this->toArray();
        $sum = 0;
        foreach($arr as $key => $value) 
        {
            if(strpos($key, 'notify_') !== false) {
                $sum += $this->$key;
            }
        }
        
        $this->notification_count = $sum;
        return parent::save($options);
    }
}
