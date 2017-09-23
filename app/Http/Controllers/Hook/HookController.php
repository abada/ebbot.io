<?php

namespace App\Http\Controllers\Hook;

use App\Http\Controllers\Controller;
use App\Event;
use App\Team;

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
        }
        
        // STORE & PROCESS THE EVENT
        $event = new Event;
        $event->team_id = $team->id;
        $event->sns_message_id = $request->json('MessageId');
        $event->sns_type = $request->header('x-amz-sns-message-type');
        $event->payload = json_encode($request->json()->all());
        $event->save();
        
        return "OK";
    }
}
