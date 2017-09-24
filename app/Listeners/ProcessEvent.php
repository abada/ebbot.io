<?php

namespace App\Listeners;

use App\EbEnvironment;
use App\Events\NewEvent;
use App\Libraries\SNSParser\SNSParser;
use App\Repositories\TeamRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;



class ProcessEvent
{
    
    protected $teamRepo;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TeamRepository $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    /**
     * Handle the event.
     *
     * @param  NewEvent  $event
     * @return void
     */
    public function handle(NewEvent $event)
    {
        // FETCH BASIC INFORMATION
        $eb_event = $event->eb_event;
        $team = $eb_event->team;
        $eb_environment = $this->teamRepo->persistEnvironmentForTeam($team, $eb_event->getEbApplication(), $eb_event->getEbEnvironment());
      
        // PARSE SNS EVENT
        $snsParser = new SNSParser();
        $snsParser->parse($eb_event);
    }
}
