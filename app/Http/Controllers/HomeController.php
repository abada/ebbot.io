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
        $this->middleware('auth');
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
        $environments = $this->ebEnvironmentRepo->organize($team->ebenvironments()->orderby('eb_application')->orderby('eb_environment')->get());
        return view('home', ['team' => $team, 'environments' => $environments]);
    }
}
