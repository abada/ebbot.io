@extends('spark::layouts.app')

@section('content')
    
    <div class="container">
        <beanbot-dashboard :current-team="currentTeam"></beanbot-dashboard>
    </div>
    
    <div class="container">
        
        <div class="panel panel-default">
            <div class="panel-body" style="padding:50px;">
                
                <environment-add endpoint="{{ url('/api/hooks/'.$team->endpoint) }}"></environment-add>
                
            </div>      
        </div>
    </div>

@endsection