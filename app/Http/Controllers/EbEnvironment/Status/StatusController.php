<?php

namespace App\Http\Controllers\EbEnvironment\Status;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
 
    public function index(Request $request, $eb_environment_id) 
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
            
        $statuses = $eb_environment->statuses()
            ->orderBy('id', 'DESC')->paginate(50);
        
        return view('eb-environments.status.index', [
            'eb_environment' => $eb_environment, 'statuses' => $statuses]);
    }
       
}