<?php

namespace App\Repositories;

use App\EbEnvironment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Oefenweb\Statistics\Statistics;
use Lava;

class EbEnvironmentStatusRepository 
{
    
    public function getStatusChangesForEnvironmentOverDaysDataTable(EbEnvironment $env, $days = 30) {
    
        $rawData = $this->getStatusChangesForEnvironmentOverDaysData($env, $days);
        
        // DEFINE TABLE STRUCTURE
        $dataTable = Lava::DataTable();
        $dataTable->addDateColumn('Date');
        $dataTable->addNumberColumn('Ok');
        $dataTable->addNumberColumn('Info');
        $dataTable->addNumberColumn('Warning');
        $dataTable->addNumberColumn('Degraded');
        $dataTable->addNumberColumn('Severe');
        $dataTable->addNumberColumn('Unknown');
        
        foreach($rawData as $row) {
            $dataTable->addRow([$row->date, $row->ok, $row->info, $row->warning, $row->degraded, $row->severe, $row->unknown]);
        }
        
        return $dataTable;
    }
    
    public function getStatusChangesForEnvironmentOverDaysData(EbEnvironment $env, $days = 30) {
        
        if(!is_integer($days)) {
            throw new \Exception('DeploymentRepository@getDeploymentsOverLastDaysChartData Parameter 1 [days] must be an integer');
        }
        
        return DB::select("
            SELECT 
            	date(days.date) as date,
            	SUM(CASE WHEN status='Ok' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as ok,
            	SUM(CASE WHEN status='Info' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as info,
            	SUM(CASE WHEN status='Warning' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as warning,
            	SUM(CASE WHEN status='Degraded' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as degraded,
            	SUM(CASE WHEN status='Severe' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as severe,
            	SUM(CASE WHEN status='Unknown' THEN TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END)) ELSE 0 END) / SUM(TIMESTAMPDIFF(SECOND, status_started_at, (CASE WHEN status_ended_at IS NULL THEN NOW() ELSE status_ended_at END))) as unknown
            FROM 
            	days
            	LEFT JOIN eb_environment_statuses ON date(status_started_at) = days.date AND eb_environment_id = ?
            WHERE days.date >= DATE(DATE_SUB(NOW(), INTERVAL {$days} DAY))
            GROUP BY days.date;
        ", [$env->id]);
    }
    
}