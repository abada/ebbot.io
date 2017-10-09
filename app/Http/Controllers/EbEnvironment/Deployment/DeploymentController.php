<?php

namespace App\Http\Controllers\EbEnvironment\Deployment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeploymentController extends Controller
{
 
    public function index(Request $request, $eb_environment_id) 
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
            
        $deployments = $eb_environment->deployments()
            ->orderBy('id', 'DESC')->paginate(50);
        
        return view('eb-environments.deployments.index', [
            'eb_environment' => $eb_environment, 'deployments' => $deployments]);
    }
       
}