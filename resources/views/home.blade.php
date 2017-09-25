@extends('spark::layouts.app')

@section('content')
    <br />
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
        
        <div class="panel panel-default">
            <table class="table">
            @foreach($environments as $eb_app => $ebs) 
            
                <tr style="border-top:3px solid #D3E0E9">
                    <th width="1"><i class="fa fa-3x fa-globe"></i></th>
                    <th colspan="2">{{ $eb_app }}</th>
                    <th>Status</th>
                    <th>Last Deploy</th>
                    <th style="text-align: right"><i class="fa fa-bullhorn"></i></th>
                    <th></th>
                </tr>
    
                @foreach($ebs as $eb)
                <tr>
                    <td></td>
                    <td width="1"><i class="fa fa-circle"></i></td>
                    <td style="font-family:monospace;">
                        {{ $eb->eb_environment }}
                    </td>
                    <td>
                        @if($eb->status)
                            {{ $eb->status->status }}
                        @else
                            <em>Unknown</em>
                        @endif
                    </td>
                    <td>
                        @if($eb->last_deployment)
                            @if(!is_null($eb->last_deployment->deployment_completed_at))
                                {{ $eb->last_deployment->deployment_completed_at->toDateTimeString() }}<br />
                                <small>
                                    {{ $eb->last_deployment->deployment_completed_at->diffForHumans() }}
                                    (~ {{ $eb->last_deployment->deployment_completed_at->diffForHumans($eb->last_deployment->created_at, true) }})
                                </small>
                            @else
                                <i class="fa fa-refresh fa-spin"></i> Deploying...
                            @endif
                        @else
                            <em>Unknown</em>
                        @endif
                    </td>
                    <td style="text-align:right">
                        0
                    </td>
                    <td width="1">
                        <a href="/eb-environments/{{ $eb->id }}" class="btn btn-default">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </table>
    </div>
    
@endsection
