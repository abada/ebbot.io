<?php

namespace App\Http\Controllers\API\Hook;

use App\Http\Controllers\Controller;
use App\Event;
use App\Events\NewEvent;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HookController extends Controller
{

    public function index(Request $request)
    {
        return redirect('/home');
    }
    
    /**
     * handle an inbound web hook
     *
     * @return Response
     */
    public function hook(Request $request, $endpoint)
    {
        $team = Team::where('endpoint', $endpoint)->first();
        if(is_null($team)) {
            abort(401, 'Unauthorized');
        }
        
        if(!$request->hasHeader('x-amz-sns-message-type')) {
            abort(400, 'Inavlid Request');
        }
        
        if($request->header('x-amz-sns-message-type') == 'SubscriptionConfirmation') 
        {
            // ACCEPT AND CONFIRM SNS SUBSCRIPTION
            $subscribeUrl = $request->json('SubscribeURL');
            file_get_contents($subscribeUrl);
            
            if(is_null($team->sns_subscribed_at)) {
                // TRACK SNS SUBSCRIPTION
                $team->sns_subscribed_at = Carbon::now();
                $team->save();
            }
        }
        
        // STORE & PROCESS THE EVENT
        $eb_event = new Event;
        $eb_event->team_id = $team->id;
        $eb_event->sns_message_id = $request->json('MessageId');
        $eb_event->sns_type = $request->header('x-amz-sns-message-type');
        $eb_event->payload = json_encode($request->json()->all());
        $eb_event->save();
        
        event(new NewEvent($eb_event));
        
        return "OK";
    }
}
