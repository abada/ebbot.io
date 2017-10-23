<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEbEnvironmentStatusesRenameStatusSetAtToStatusStartedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environment_statuses', function (Blueprint $table) {
            $table->renameColumn('status_set_at', 'status_started_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eb_environment_statuses', function (Blueprint $table) {
            $table->renameColumn('status_started_at', 'status_set_at');
        });
    }
}
