<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDeploymentsTableAddDurationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environment_deployments', function (Blueprint $table) {
            $table->integer('duration')->unsigned()->nullable()->default(null)->after('deployment_healthy_at');
            $table->integer('duration_projected')->unsigned()->nullable()->default(null)->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eb_environment_deployments', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->dropColumn('duration_projected');
        });
    }
}
