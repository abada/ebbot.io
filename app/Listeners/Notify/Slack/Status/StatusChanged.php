<?php

namespace App\Listeners\Notify\Slack\Status;

use App\Events\EbEnvironmentStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatusChanged
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EbEnvironmentStatusChanged  $event
     * @return void
     */
    public function handle(EbEnvironmentStatusChanged $event)
    {
        //
    }
}
