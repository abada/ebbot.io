<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbEnvironmentDeployment extends Model
{
    
    public function eb_environment() 
    {
        return $this->belongsTo('App\EbEnbironment');
    }
    
}
