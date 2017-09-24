<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbEnvironmentDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eb_environment_deployments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eb_environment_id')->unsigned();
            $table->timestamp('deployment_completed_at')->nullable()->default(null);
            $table->timestamp('deployment_healthy_at')->nullable()->default(null);
            $table->timestamps();
            
            $table->index('created_at');
            $table->index('eb_environment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eb_environment_deployments');
    }
}
