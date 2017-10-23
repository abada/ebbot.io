<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EbEnvironment;
use App\EbEnvironmentStatus;
use Carbon\Carbon;
use DB;

class StatusNewDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:newDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creates a new status that starts at midnight for all environments';

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
        $today = Carbon::today();
        
        $environments = EbEnvironment::all();
        $this->output->progressStart($environments->count());
        
        foreach($environments as $environment) 
        {
            $date = $today->copy();
            
            while($environment->created_at->lt($date)) {
                
                $status = null;
                $previousStatus = null;
                $nextStatus = null;
                
                $status = $environment->statuses()
                    ->where('status_started_at', $date)
                    ->first();
                    
                if(is_null($status)) {
                    
                    $previousStatus = $environment->statuses()
                        ->where('status_started_at', '<', $date)
                        ->orderBy('status_started_at', 'DESC')
                        ->first(); 
                        
                    $nextStatus = $environment->statuses()
                        ->where('status_started_at', '>=', $date)
                        ->orderBy('status_started_at')
                        ->first(); 
                      
                    $status = new EbEnvironmentStatus;
                    $status->status = is_null($previousStatus) ? 'Unknown' : $previousStatus->status;
                    $status->status_started_at = $date;
                    if($nextStatus) {
                        $status->status_ended_at = $nextStatus->status_started_at;
                    }
                    $status->created_at = $date;
                    $status->is_fake = true;
                    $status->eb_environment_id = $environment->id;
                    $status->save();
                    
                    if($previousStatus) {
                        $previousStatus->status_ended_at = $date;
                        $previousStatus->save();
                    }
                }
                
                $date = $date->subDays(1);
            }
            
            
            
            $this->output->progressAdvance();
            
        }
        
        $this->output->progressFinish();
    }
}
