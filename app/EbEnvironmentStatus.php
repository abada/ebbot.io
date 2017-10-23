<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EbEnvironmentStatus extends Model
{
    public $dates = ['status_started_at', 'status_ended_at'];
    
    public function eb_environment() 
    {
        return $this->belongsTo('App\EbEnvironment');
    }
    
}
