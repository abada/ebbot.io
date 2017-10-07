<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EbEnvironmentDeployment;

class BackfillDeploymentDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:deploymentDuration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backfill the projected and actual deployment duration numbers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $deployments = EbEnvironmentDeployment::all();

        $bar = $this->output->createProgressBar(count($deployments));
        
        foreach ($deployments as $deployment) {
            $duration = null;
            
            // CALCULATE ACTUAL DEPLOYMENT DURATION
            if(is_null($deployment->deployment_completed_at)) {
                $deployment->deployment_completed_at = $deployment->deployment_healthy_at;
            }
            $completed_at = $deployment->deployment_completed_at;
            $started_at   = $deployment->created_at;
            
            if(!is_null($completed_at)) {
                $duration     = $started_at->diffInSeconds($completed_at);
            }
            
            $deployment->duration = $duration;
            $deployment->save();
            
            $bar->advance();
        }
        
        $bar->finish();

        
    }
    
}
