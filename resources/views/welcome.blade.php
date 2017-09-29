@extends('spark::layouts.app-nonav')

@section('content')
    
    <div class="hero">
        
        <div class="container text-left">
            <div class="brand">BeanBot<span class="suffix">.io</span></div>
            <div class="slug">
                Streamlined Monitoring for Elastic Beanstalk Apps
             </div>
                
            <div class="extra">
                <ul>
                    <li>
                        <strong>Deployments:</strong>
                        <small>Start / Complete / Healthy...</small>
                    </li>
                    <li>
                        <strong>Application Status:</strong>
                        <small>Warning / Degraded  /  Severe...</small>
                    </li>
                    <li>
                        <strong>Insights:</strong>
                        <small>Live Deploys / Deploy Runtime / Deploy Rate / Status Change Logs...</small>
                    </li>
                </ul>
                
                <a href="/login" class="btn btn-default">Log In</a>
                <a href="/login" class="btn btn-default">Get Set Up In 15 Minutes</a>
            </div>
        </div>
        
    </div>

@endsection