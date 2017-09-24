<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    
    protected $eb = null;
    
    public function team() 
    {
        return $this->belongsTo('App\Team');    
    }
    
    public function isEbNotification() {
        $subject = (json_decode($this->payload))->Subject;
        return $this->sns_type == 'Notification' && strpos($subject, 'AWS Elastic Beanstalk Notification') >= 0;
    }
    
    public function getEbTimestamp() 
    {
        return $this->getEBMessageValueFromKey('timestamp');
    }
    
    public function getEbApplication() 
    {
        return $this->getEBMessageValueFromKey('application');
    }
    
    public function getEbEnvironment() 
    {
        return $this->getEBMessageValueFromKey('environment');
    }
    
    public function getEbMessage() 
    {
        return $this->getEBMessageValueFromKey('message');
    }
    
    /**
     * get all the avaialbe from the message payload
     * 
     * @return array[string] the keys in the sns message payload
     */
    public function getEBMessageKeys()
    {
        $this->parseEBMessage();
        return array_keys($this->eb);
    }
    
    /**
     * get the value of a given key from the sns payload
     * 
     * @param string $key the key to fetch a value for
     * @return mixed|null the value associated with the key or null if unknown
     */
    public function getEBMessageValueFromKey($key)
    {
        $this->parseEBMessage();
        return array_key_exists($key, $this->eb) ? $this->eb[$key] : null;
    }
    
    /**
     * parses the sns message on the fly an makes its keys and values
     * available to the Event instance's methods
     * 
     * @return boolean success of parsing the message
     */
    protected function parseEBMessage() 
    {
        if(!is_null($this->eb)) {
            return true;
        }
        
        // EXTRACT PAYLOAD
        $payload = json_decode($this->payload);
        
        // PARSE SNS MESSAGE
        $eb = [
            'timestamp' => null,
            'message' => null,
            'environment' => null,
            'application' => null,
            'environment_url' => null,
            'notificationprocessid' => null,
        ];
        $rows = explode("\n", $payload->Message);
        foreach($rows as $row) 
        {
            $components = explode(':', $row, 2);
            if(count($components) == 2) {
                
                $key = trim(strtolower(str_replace(' ', '_', $components[0])));
                
                if($key == 'timestamp') 
                {
                    $value = new Carbon(trim($components[1]));
                }
                else 
                {
                    $value = trim($components[1]);    
                }
            
                
                $eb[$key] = $value;
            }
        }
        $this->eb = $eb;
        return true;
    }
    
    
    
}
