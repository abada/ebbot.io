<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbEnvironmentStatus extends Model
{
    
    public $dates = ['status_set_at', 'status_ended_at'];
    
    public function eb_environment() 
    {
        return $this->belongsTo('App\EbEnvironment');
    }
    
}
