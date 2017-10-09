<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BbNotifcation extends Model
{
    
    public function team() 
    {
        return $this->belongsTo('App\Team');
    }
    
    public function notifiable() 
    {
        return $this->morphTo();
    }
    
}
