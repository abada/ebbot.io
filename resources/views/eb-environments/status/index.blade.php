@extends('spark::layouts.app')

@section('content')

    <div class="container">
        @include('eb-environments._nav')
        
        <div class="panel panel-default panel-tabnav">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1"></th>
                            <th width="50">Status</th>
                            <th>Entered Status</th>
                            <th>SNS Latency</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statuses as $status)
                        <tr>
                            <td>
                                <i class="fa fa-circle fa-2x status-{{ strtolower($status->status) }}"></i>
                            </td>
                            <td style="font-family:monospace; vertical-align:middle;">
                                <strong>{{ $status->status }}</strong>
                            </td>
                            <td style="vertical-align:middle;">
                                {{ $status->status_set_at }}&nbsp;&nbsp;
                                <small>({{ $status->status_set_at->diffForHumans() }})</small>
                            </td>
                            <td style="vertical-align:middle;">
                                {{ $status->status_set_at->diffForHumans($status->created_at, true) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $statuses->links() }}
            </div>
        </div>
    </div>

@endsection
    