<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEbEnvironmentStatusesTableAddEndedAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environment_statuses', function (Blueprint $table) {
            $table->timestamp('status_ended_at')->nullable()->default(null)->after('status_set_at');
            $table->index('status_ended_at');
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
            $table->dropColumn('status_ended_at');
        });
    }
}
