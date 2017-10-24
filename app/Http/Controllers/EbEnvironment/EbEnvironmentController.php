<?php

namespace App\Http\Controllers\EbEnvironment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DeploymentRepository;
use App\Repositories\EbEnvironmentStatusRepository;
use Lava;

class EbEnvironmentController extends Controller
{
    
    protected $deploymentRepo;
    protected $ebEnvironmentStatusRepo;
 
    public function __construct(DeploymentRepository $deploymentRepo, EbEnvironmentStatusRepository $ebEnvironmentStatusRepo)
    {
        $this->deploymentRepo = $deploymentRepo;
        $this->ebEnvironmentStatusRepo = $ebEnvironmentStatusRepo;
    }
 
    public function index() 
    {
        return redirect('/home');    
    }
    
    public function show(Request $request, $eb_environment_id)
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
            
        $days = ($request->has('days') ? intval($request->input('days')) : 14);

        // PREPARE CHARTS            
        $deploymentsDataTable = $this->deploymentRepo->getNumberOfDeploymentsOverLastDaysDataTable($eb_environment, $days);
        Lava::ColumnChart('chart_deployment_days', $deploymentsDataTable, [
            'isStacked' => true, 
            'legend' => 'top', 
            'colors' => ['#A4AAAD'],
            'height' => 200,
            'chartArea' => ['width' => '90%', 'height' => '70%'],
        ]);
        
        
        // PREPARE CHARTS            
        $statusDataTable = $this->ebEnvironmentStatusRepo->getStatusChangesForEnvironmentOverDaysDataTable($eb_environment, $days);
        Lava::ColumnChart('chart_status_days', $statusDataTable, [
            'isStacked' => true, 
            'legend' => 'top', 
            'colors' => ['#6EAF5D', '#2A99CE', '#FFBD4A', '#F05050', '#990000', '#CCCCCC'],
            'height' => 200,
            'chartArea' => ['width' => '90%', 'height' => '70%'],
        ]);
        
        return view('eb-environments.show', ['eb_environment' => $eb_environment, 'days' => $days]);
    }
    
    public function edit(Request $request, $eb_environment_id)
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
        
        return view('eb-environments.edit', ['eb_environment' => $eb_environment]);
    }
    
     public function update(Request $request, $eb_environment_id)
    {
        $eb_environment = $request->user()
            ->currentTeam()->ebenvironments()->find($eb_environment_id);
        
        // SLACK SETTINGS
        $eb_environment->notification_slack = $request->has('notification_slack');
        $eb_environment->notification_slack_hook = $request->input('notification_slack_hook');
        $eb_environment->notification_slack_channel = $request->input('notification_slack_channel');
        
        // PREFERENCES
        
        // dashboards
        $eb_environment->dashboard_tv = $request->has('dashboard_tv');
        $eb_environment->dashboard_tv_group = $request->input('dashboard_tv_group');
        
        // deployments
        $eb_environment->notify_deployment_start = $request->has('notify_deployment_start');
        $eb_environment->notify_deployment_complete = $request->has('notify_deployment_complete');
        $eb_environment->notify_deployment_healthy = $request->has('notify_deployment_healthy');
        
        // status
        $eb_environment->notify_status_ok = $request->has('notify_status_ok');
        $eb_environment->notify_status_info = $request->has('notify_status_info');
        $eb_environment->notify_status_unknown = $request->has('notify_status_unknown');
        $eb_environment->notify_status_warning = $request->has('notify_status_warning');
        $eb_environment->notify_status_degraded = $request->has('notify_status_degraded');
        $eb_environment->notify_status_severe = $request->has('notify_status_severe');
        
        $eb_environment->save();
    
        return redirect("/eb-environments/{$eb_environment_id}/settings");
    }
       
}