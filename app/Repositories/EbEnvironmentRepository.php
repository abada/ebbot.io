<?php

namespace App\Repositories;

class EbEnvironmentRepository 
{
    
    public function organize($envrionments)
    {
        $organzied = [];
        foreach($envrionments as $env) 
        {
            if(!array_key_exists($env->eb_application, $organzied)) 
            {
                $organzied[$env->eb_application] = [];
            }
            $organzied[$env->eb_application][] = $env;
        }
        return $organzied;
    }
    
}