<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EbEnvironmentStatus;

class BackfillStatusEndedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:statusEndedAt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backfill the end date of all statuses';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $statuses = EbEnvironmentStatus::all();

        $bar = $this->output->createProgressBar(count($statuses));
        
        foreach ($statuses as $status) {
            
            $nextStatus = $status->eb_environment->statuses()
                ->where('status_set_at', '>', $status->status_set_at)
                ->orderBy('status_set_at')
                ->limit(1)
                ->first();
                
            if(!is_null($nextStatus)) {
                $status->status_ended_at = $nextStatus->status_set_at;
                $status->save();
            }
            
            $bar->advance();
        }
        
        $bar->finish();

        
    }
    
}
