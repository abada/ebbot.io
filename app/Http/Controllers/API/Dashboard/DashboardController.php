<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\EbEnvironmentRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    protected $ebEnvironmentRepo;
    
    public function __construct(EbEnvironmentRepository $ebEnvironmentRepo)
    {
        $this->ebEnvironmentRepo = $ebEnvironmentRepo;
    }

    public function index(Request $request)
    {
        
        $team = $request->user()->currentTeam;
        $envs = $team->ebenvironments()
            ->with(['status', 'last_deployment'])
            ->orderBy('eb_application')
            ->orderBy('eb_environment')
            ->get();
            
        return $this->ebEnvironmentRepo->organize($envs);
        
    }
    
    public function tv(Request $request)
    {
        
        $team = $request->user()->currentTeam;
        $envs = $team->ebenvironments()
            ->with(['status', 'last_deployment'])
            ->where('dashboard_tv', 1)
            ->orderBy('eb_application')
            ->orderBy('eb_environment')
            ->get();
            
        return $this->ebEnvironmentRepo->organizeForTV($envs);
            
        return $envs;
        
    }
    
}
