@extends('spark::layouts.app')

@section('content')

    <div class="container">
        @include('eb-environments._nav')
        
        <div class="panel panel-default panel-tabnav panel-settings">
            <div class="panel-body">
        
                <form method="POST" action="/eb-environments/{{ $eb_environment->id }}" class="form-horizontal">
                    
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    
                    <h3>
                        Dashboard
                    </h3>
                    <hr />
                    <div class="settings-section" style="padding-left:20px;">
                        <div class="form-group">
                                <div class="col-sm-9 col-md-offset-1">
                                    <label for="dashboard_tv">
                                        <input type="checkbox" name="dashboard_tv" id="dashboard_tv" @if($eb_environment->dashboard_tv) checked="" @endif />&nbsp;
                                        Show on TV Dashboard
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dashboard_tv_group" class="col-sm-1 control-label">Group</label>
                                <div class="col-sm-6">
                                    <input name="dashboard_tv_group" type="text" class="form-control" id="dashboard_tv_group" placeholder="Production, Staging, api.company.com..." value="{{ $eb_environment->dashboard_tv_group }}">
                                </div>
                            </div>
                    </div>
                    <br />
                    <br />
                    
                    <h3>
                        Notifications ({{ $eb_environment->notification_count }})
                    </h3>
                    <hr />
            
                    <div class="settings-section">
                        <div class="row">
                            <div class="col-md-4">
                                <h4>
                                    Deployments
                                </h4>
                                
                                <div class="settings-section" style="padding-left:20px;">
                                
                                    <div class="media">
                                        <div class="media-left">
                                            <input type="checkbox" name="notify_deployment_start" @if($eb_environment->notify_deployment_start) checked="" @endif />
                                        </div>
                                        <div class="media-body">
                                            <strong>On Deploy Start</strong><br />
                                            <small>Get a ping every Elastic Beanstalk begins updating your running instances.</small>
                                        </div>
                                    </div>         
                                    
                                    <div class="media">
                                        <div class="media-left">
                                            <input type="checkbox" name="notify_deployment_complete" @if($eb_environment->notify_deployment_complete) checked="" @endif />
                                        </div>
                                        <div class="media-body">
                                            <strong>On Deploy Complete</strong><br />
                                            <small>Get a ping every an update has been applied to all instances in the application.</small>
                                        </div>
                                    </div>        
                                    
                                    <div class="media">
                                        <div class="media-left">
                                            <input type="checkbox" name="notify_deployment_healthy" @if($eb_environment->notify_deployment_healthy) checked="" @endif />
                                        </div>
                                        <div class="media-body">
                                            <strong>On Deploy Healthy</strong><br />
                                            <small>Get a ping every an update has been completed and the status goes back to OK.</small>
                                        </div>
                                    </div>        
                                    
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-1">
                                <h4>
                                    Environment Status
                                </h4>
                                <div class="settings-section" style="padding-left:20px;">
                            
                                    <p>
                                        <small>
                                            Pick the states that you want to be notified about.
                                            We will issue a notification every time your enters,
                                            leaves, or transitions between the checked options below.
                                        </small>
                                    </p>    
                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_ok" @if($eb_environment->notify_status_ok) checked="" @endif/>
                                                </div>
                                                <div class="media-body status-ok">
                                                    <strong>Ok</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_info" @if($eb_environment->notify_status_info) checked="" @endif />
                                                </div>
                                                <div class="media-body status-info">
                                                    <strong>Info</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_unknown" @if($eb_environment->notify_status_unknown) checked="" @endif />
                                                </div>
                                                <div class="media-body status-unknown">
                                                    <strong>Unknown</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_warning"  @if($eb_environment->notify_status_warning) checked="" @endif />
                                                </div>
                                                <div class="media-body status-warning">
                                                    <strong>Warning</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_degraded"  @if($eb_environment->notify_status_degraded) checked="" @endif />
                                                </div>
                                                <div class="media-body status-degraded">
                                                    <strong>Degraded</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name="notify_status_severe" @if($eb_environment->notify_status_severe) checked="" @endif />
                                                </div>
                                                <div class="media-body status-severe">
                                                    <strong>Severe</strong>
                                                </div>
                                            </div>       
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <br />
                    </div>
                    <br />
                    <br />
                    
                    <!-- SLACK CONFIGURATION -->
                    <h3>
                        Slack
                    </h3>
                    <hr />
                    <br />
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <div class="col-sm-9 col-md-offset-3">
                                    <label for="notification_slack">
                                        <input type="checkbox" name="notification_slack" id="notification_slack" @if($eb_environment->notification_slack) checked="" @endif />&nbsp;
                                        Enable Slack Integration
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notification_slack_hook" class="col-sm-3 control-label">Slack Hook</label>
                                <div class="col-sm-9">
                                    <input name="notification_slack_hook" type="text" class="form-control" id="notification_slack_hook" placeholder="https://hooks.slack.com/services/XXX/ZZZ" value="{{ $eb_environment->notification_slack_hook }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="notification_slack_hook_channel" class="col-sm-3 control-label">Channel / User</label>
                                <div class="col-sm-9">
                                    <input name="notification_slack_channel" type="text" class="form-control" id="notification_slack_channel" placeholder="#devops" value="{{ $eb_environment->notification_slack_channel }}">
                                    <small>Make sure to include the <code>#</code> or <code>@</code>.</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-1">
                            <p>
                                <strong>Why a Slack hook and not an app?</strong><br />
                                <small>
                                    Simple, Slack has a limit of how many apps you can have on your team before you exceed
                                    the free-tier. With slack hooks, this issue does not exist and you can use it
                                    for any number of applications. For example: <a href="https://envbeat.com">Envbeat.com</a>
                                </small>
                            </p>
                        </div>
                    </div>
                    <br />
                    <br />
                
                    <!-- SAVE / RESET BUTTONS -->
                    <div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            Save Changes
                        </button>&nbsp;&nbsp;
                        <button type="reset" class="btn btn-default btn-lg">
                            Cancel
                        </button>
                    </div>
                    <small>
                        Last Saved: {{ $eb_environment->updated_at->diffForHumans() }}
                    </small>
                
                </form>   
                
            </div>
        </div>
    </div>

@endsection