@extends('spark::layouts.app')

@section('content')
    <div class="container">
        <!-- Application Dashboard -->
        @if(is_null($team->sns_subscribed_at) || is_null($team->sns_eb_received_at))
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Get Started: Connect Your Elastic Beanstalk Notification</div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                
                                @if(is_null($team->sns_subscribed_at))
                                    <div class="text-center">
                                        <br />
                                        <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                        <br /><br />
                                        <p>
                                            For BeanBot to work, it needs to subscribe to a topic.
                                        </p>
                                        <a href="/connect/subscribe" class="btn btn-default">Let's Go</a>
                                    </div>
                                    <br />
                                @else
                                    <div class="text-center">
                                        <br />
                                        <i class="fa fa-check-circle fa-3x"></i>
                                        <br /><br />
                                        <p>
                                            BeanBot has a coms channel with AWS!
                                        </p>
                                    </div>
                                @endif
                                
                            </div>
                            <div class="col-md-6 text-center">
                                
                                @if(is_null($team->sns_eb_received_at) && !is_null($team->sns_subscribed_at))
                                    <div class="text-center">
                                        <br />
                                        <i class="fa fa-circle-o-notch fa-spin fa-3x"></i>
                                        <br /><br />
                                        <p>
                                            Beanbot is waiting for the first message.
                                        </p>
                                        <a href="/connect/subscribe" class="btn btn-default">Connect Your Environment</a>
                                    </div>
                                    <br />
                                @else
                                    <div class="text-center">
                                        <br />
                                        <i class="fa fa-check-circle fa-3x"></i>
                                        <br /><br />
                                        <p>
                                            BeanBot has received a beanstalk event.
                                        </p>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                        
                        <hr>
                        
                        {{ $team->name}}'s BeanBot HTTPS Endpoint:<br /> 
                        <span style="font-family:monospace;">{{ url('/api/hooks/'.$team->endpoint) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @foreach($environments as $environment) 
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $environment->eb_application }}
                    </div>
                    <div class="panel-body">
                        {{ $environment->eb_environment }} ({{ $environment->deployments()->count() }} deployments)
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection
