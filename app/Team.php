<?php

namespace App;

use Laravel\Spark\Team as SparkTeam;

class Team extends SparkTeam
{
    
    public function ebenvironments() 
    {
        return $this->hasMany('App\EbEnvironment');
    }
    
}
