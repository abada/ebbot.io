@extends('spark::layouts.app')

@section('content')

    <div class="container-fluid">
        @include('eb-environments._nav')
        
        <div class="panel panel-default panel-tabnav">
            <div class="panel-body">
                
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Timeframe: last <strong>{{ $days }}</strong> days <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/eb-environments/{{ $eb_environment->id }}?days=7">7 Days</a></li>
                    <li><a href="/eb-environments/{{ $eb_environment->id }}?days=14">14 Days</a></li>
                    <li><a href="/eb-environments/{{ $eb_environment->id }}?days=30">30 Days</a></li>
                    <li><a href="/eb-environments/{{ $eb_environment->id }}?days=90">90 Days</a></li>
                  </ul>
                </div>
                <br />
                <br />
                
                <div class="row">
                    <div class="col-md-6">
                        
                        <h3>Status Changes <small>over the last {{ $days }} days</small></h3>
                        <br />
                        <div id="chart_status_days"></div>
                        <?= Lava::render('ColumnChart', 'chart_status_days', 'chart_status_days') ?>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <h3>Deployments <small>over the last {{ $days }} days</small></h3>
                        <br />
                        <div id="chart_deployments_days"></div>
                        <?= Lava::render('ColumnChart', 'chart_deployment_days', 'chart_deployments_days') ?>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@endsection