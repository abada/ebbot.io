@extends('spark::layouts.app-sidebar')

@section('hero')
    @include('eb-environments._hero')
@endsection

@section('sidebar')
    @include('eb-environments._nav')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="1"></th>
                        <th width="50">Status</th>
                        <th>Started</th>
                        <th>Ended</th>
                        <th>Duration</th>
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
                            {{ $status->status_started_at }}&nbsp;&nbsp;
                            <small>({{ $status->status_started_at->diffForHumans() }})</small>
                        </td>
                        <td style="vertical-align:middle;">
                            @if(!is_null($status->status_ended_at))
                                {{ $status->status_ended_at }}&nbsp;&nbsp;
                            @else
                                <em>Ongoing...</em>
                            @endif
                        </td>
                        <td>
                            {{ $status->status_started_at->diffForHumans($status->status_ended_at, true) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $statuses->links() }}
        </div>
    </div>
@endsection
    