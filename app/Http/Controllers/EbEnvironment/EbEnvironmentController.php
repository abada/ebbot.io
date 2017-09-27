<?php

namespace App\Http\Controllers\EbEnvironment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EbEnvironmentController extends Controller
{
 
    public function index() 
    {
        return redirect('/home');    
    }
    
    public function show(Request $request, $eb_environment_id)
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
        
        return view('eb-environments.show', ['eb_environment' => $eb_environment]);
    }
    
    public function edit(Request $request, $eb_environment_id)
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
        
        return view('eb-environments.edit', ['eb_environment' => $eb_environment]);
    }
       
}