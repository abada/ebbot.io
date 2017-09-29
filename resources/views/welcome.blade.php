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
                        <strong>Notifications:</strong>
                        <small>Deployments / Status Changes / Scaling...</small>
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