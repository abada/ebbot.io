<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;

class BackfillEventEbCreatedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backfill:eventEbCreatedAt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'backfill the eb timestamps for all events';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $eventIds = Event::whereNull('eb_created_at')->pluck('id');
        
        $lag = 0;
        $bar = $this->output->createProgressBar(count($eventIds));
        foreach ($eventIds as $eventId) {
            
            $event = Event::find($eventId);
            $event->eb_created_at = $event->getEbSNSTimestamp();
            $event->save();
            
            $lag+= $event->eb_created_at->diffInSeconds($event->created_at);
            
            $bar->advance();
        }
        
        $bar->finish();
        
        $this->info('');
        $this->info('Lag: '.($lag / count($eventIds)));
    }
    
}
