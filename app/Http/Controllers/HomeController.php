<?php

namespace App\Http\Controllers;

use App\Repositories\EbEnvironmentRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EbEnvironmentRepository $ebEnvironmentRepo)
    {
        $this->ebEnvironmentRepo = $ebEnvironmentRepo;  
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $team = $request->user()->currentTeam;
        return view('dashboard', ['team' => $team]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function showTV(Request $request)
    {
        $team = $request->user()->currentTeam;
        return view('dashboard_tv', ['team' => $team]);
    }
}
