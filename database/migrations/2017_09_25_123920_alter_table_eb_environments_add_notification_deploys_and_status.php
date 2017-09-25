<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEbEnvironmentsAddNotificationDeploysAndStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environments', function (Blueprint $table) {
            
            $table->boolean('notification_slack')->default(false);
            $table->string('notification_slack_hook', 512)->nullable()->default(null);
            $table->string('notification_slack_channel', 100)->nullable()->default(null);
            
            $table->boolean('notify_deployment_start')->default(false);
            $table->boolean('notify_deployment_complete')->default(false);
            $table->boolean('notify_deployment_healthy')->default(false);
            
            $table->boolean('notify_status_ok')->default(false);
            $table->boolean('notify_status_info')->default(false);
            $table->boolean('notify_status_unknown')->default(false);
            $table->boolean('notify_status_warning')->default(false);
            $table->boolean('notify_status_degraded')->default(false);
            $table->boolean('notify_status_severe')->default(false);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eb_environments', function (Blueprint $table) {
            
            $table->dropColumn('notification_slack');
            $table->dropColumn('notification_slack_hook');
            $table->dropColumn('notification_slack_channel');
            
            $table->dropColumn('notify_deployment_start');
            $table->dropColumn('notify_deployment_complete');
            $table->dropColumn('notify_deployment_healthy');
            
            $table->dropColumn('notify_status_ok');
            $table->dropColumn('notify_status_info');
            $table->dropColumn('notify_status_unknown');
            $table->dropColumn('notify_status_warning');
            $table->dropColumn('notify_status_degraded');
            $table->dropColumn('notify_status_severe');
            
        });
    }
}
