<?php

namespace App\Repositories;

use App\EbEnvironment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Oefenweb\Statistics\Statistics;
use Lava;

class DeploymentRepository 
{

    public function getLastDeploymentForEbEnvironment(EbEnvironment $env)
    {
        return $env->deployments()->latest('created_at')->first();
    }
    
    public function getProjectedDeploymentDurationForEbEnvironment(EbEnvironment $env, Carbon $before = null)
    {
        $query = $env->deployments()->orderBy('id', 'DESC');
        if(!is_null($before)) {
            $query = $query->where('created_at', '<', $before);
        }
        $durations = $query->limit(5)->pluck('duration')->toArray();
        if(count($durations) < 2) {
            return null;
        }
        
        // DETERMINE AVG & STDDEV
        $duration_avg = Statistics::mean($durations);
        $duration_stddev = Statistics::standardDeviation($durations);
        
        // ELIMINATE OUTLIERS
        $durations_without_outliers = [];
        $limit_upper = $duration_avg + $duration_stddev;
        $limit_lower = $duration_avg - $duration_stddev;
        foreach($durations as $duration) {
            if($duration <  $limit_upper && $duration > $limit_lower) {
                $durations_without_outliers[] = $duration;
            }
        }
        
        $duration_avg_without_outliers = Statistics::mean($durations_without_outliers);
        $duration_projected = $duration_avg_without_outliers * 1.10;
        
        return $duration_projected;
    }
    
    public function getNumberOfDeploymentsOverLastDaysDataTable(EbEnvironment $env, $days = 30) {
    
        $rawData = $this->getNumberOfDeploymentsOverLastDaysChartData($env, $days);
        
        // DEFINE TABLE STRUCTURE
        $dataTable = Lava::DataTable();
        $dataTable->addDateColumn('Date');
        $dataTable->addNumberColumn('Deploys');
        
        foreach($rawData as $row) {
            $dataTable->addRow([$row->date, $row->deploys]);
        }
        
        return $dataTable;
    }
    
    public function getNumberOfDeploymentsOverLastDaysChartData(EbEnvironment $env, $days = 30) {
        
        if(!is_integer($days)) {
            throw new \Exception('DeploymentRepository@getDeploymentsOverLastDaysChartData Parameter 1 [days] must be an integer');
        }
        
        return DB::select("
            SELECT 
            	days.date,
            	SUM(CASE WHEN eb_environment_deployments.deployment_completed_at IS NOT NULL THEN 1 ELSE 0 END) as 'deploys'
            FROM 
            	days
            	LEFT JOIN eb_environment_deployments ON date(eb_environment_deployments.created_at) = days.date AND eb_environment_id = ?
            WHERE days.date >= DATE(DATE_SUB(NOW(), INTERVAL {$days} DAY))
            GROUP BY days.date;

        ", [$env->id]);
    }
    
}