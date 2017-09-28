@extends('spark::layouts.app')

@section('content')
    
    <div class="container">
        <beanbot-dashboard :current-team="currentTeam"></beanbot-dashboard>
    </div>
    
    <br />
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body" style="padding:50px;">
                <environment-add endpoint="{{ url('/api/hooks/'.$team->endpoint) }}" :intro="@if($team->ebenvironments()->count() > 0) true @else false @endif"></environment-add>
            </div>      
        </div>
    </div>

@endsection