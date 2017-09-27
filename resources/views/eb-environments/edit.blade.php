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
                        Notifications
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
                                            <input type="checkbox" name=""/>
                                        </div>
                                        <div class="media-body">
                                            <strong>On Deploy Start</strong><br />
                                            <small>Get a ping every Elastic Beanstalk begins updating your running instances.</small>
                                        </div>
                                    </div>         
                                    
                                    <div class="media">
                                        <div class="media-left">
                                            <input type="checkbox" name=""/>
                                        </div>
                                        <div class="media-body">
                                            <strong>On Deploy Complete</strong><br />
                                            <small>Get a ping every an update has been applied to all instances in the application.</small>
                                        </div>
                                    </div>        
                                    
                                    <div class="media">
                                        <div class="media-left">
                                            <input type="checkbox" name=""/>
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
                                                    <input type="checkbox" name=""/>
                                                </div>
                                                <div class="media-body status-ok">
                                                    <strong>Ok</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name=""/>
                                                </div>
                                                <div class="media-body status-info">
                                                    <strong>Info</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name=""/>
                                                </div>
                                                <div class="media-body status-unknown">
                                                    <strong>Unknown</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name=""/>
                                                </div>
                                                <div class="media-body status-warning">
                                                    <strong>Warning</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name=""/>
                                                </div>
                                                <div class="media-body status-degraded">
                                                    <strong>Degraded</strong>
                                                </div>
                                            </div>       
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <input type="checkbox" name=""/>
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
                                <label for="slack_hook" class="col-sm-3 control-label">Slack Hook</label>
                                <div class="col-sm-9">
                                    <input name="slack_hook" type="text" class="form-control" id="slack_hook" placeholder="https://hooks.slack.com/services/XXX/ZZZ">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slack_to" class="col-sm-3 control-label">Channel / User</label>
                                <div class="col-sm-9">
                                    <input name="slack_to" type="text" class="form-control" id="slack_to" placeholder="#devops">
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
                    <button type="submit" class="btn btn-primary btn-lg">
                        Save Changes
                    </button>&nbsp;&nbsp;
                    <button type="reset" class="btn btn-default btn-lg">
                        Cancel
                    </button>
                
                </form>   
                
            </div>
        </div>
    </div>

@endsection