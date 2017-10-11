@extends('spark::layouts.app')

@section('content')

    <div class="container">
        @include('eb-environments._nav')
        
        <div class="panel panel-default panel-tabnav">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        
                        <h3>Status Changes <small>over the last 30 days</small></h3>
                        <br />
                        <div id="chart_status_days"></div>
                        <?= Lava::render('ColumnChart', 'chart_status_days', 'chart_status_days') ?>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <h3>Deployments <small>over the last 30 days</small></h3>
                        <br />
                        <div id="chart_deployments_days"></div>
                        <?= Lava::render('ColumnChart', 'chart_deployment_days', 'chart_deployments_days') ?>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>

@endsection