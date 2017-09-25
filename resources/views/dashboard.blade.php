@extends('spark::layouts.app')

@section('content')
    
    <div class="container">
        <beanbot-dashboard :current-team="currentTeam"></beanbot-dashboard>
    </div>

@endsection