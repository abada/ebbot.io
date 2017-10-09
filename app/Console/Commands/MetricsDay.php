<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Day;

class MetricsDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metrics:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a new day for the metrics';

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
        
        $date = new Carbon('2017-01-01');
        $today = Carbon::today();
        
        $bar = $this->output->createProgressBar($date->diffInDays($today));
        
        while($date->lte($today)){
            
            $exists = Day::where('date', $date->toDateString())->first();
            if(!$exists) {
                $day = new Day;
                $day->date = $date->toDateString();
                $day->save();
            }
            $date = $date->addDays(1);
            $bar->advance();
            
        }
        
        $bar->finish();
        
    }
}
