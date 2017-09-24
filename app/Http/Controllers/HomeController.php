<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $team = $request->user()->currentTeam;
        $environments = $team->ebenvironments()->orderby('eb_application')->orderby('eb_environment')->get();
        return view('home', ['team' => $team, 'environments' => $environments]);
    }
}
