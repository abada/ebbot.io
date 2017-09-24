<?php

namespace App\Libraries\SNSParser;

use App\Event;

interface Trigger {
    
    public function shouldFire(Event $eb_event);
    
    public function fire(Event $eb_event);
    
}