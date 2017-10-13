@extends('spark::layouts.app')

@section('content')

    <div class="container-fluid">
        @include('eb-environments._nav')
        
        <div class="panel panel-default panel-tabnav">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1"></th>
                            <th>Started</th>
                            <th>Completed</th>
                            <th>Healthy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deployments as $deployment)
                        <tr>
                            <td>
                                @if(is_null($deployment->deployment_completed_at))
                                    <i class="fa fa-refresh fa-spin"></i>
                                @elseif(is_null($deployment->deployment_healthy_at))
                                    <i class="fa fa-warning status-warning"></i>
                                @else
                                    <i class="fa fa-circle status-ok"></i>
                                @endif
                            </td>
                            <td>
                                {{ $deployment->created_at }}<br />
                                <small>{{ $deployment->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                {{ $deployment->deployment_completed_at }}<br />
                                <small>{{ $deployment->deployment_completed_at->diffForHumans($deployment->created_at) }} start</small>
                            </td>
                            <td>
                                @if(is_null($deployment->deployment_healthy_at))
                                    <em>
                                        Never<br />
                                        <small>This deploy did not transition to healthy.</small>
                                    </em>
                                @else
                                    {{ $deployment->deployment_healthy_at }}<br />
                                    <small>{{ $deployment->deployment_healthy_at->diffForHumans($deployment->deployment_completed_at) }} complete</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $deployments->links() }}
            </div>
        </div>
    </div>

@endsection
    