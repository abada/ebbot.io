<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEbEnvironmentsAddNotificationCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environments', function (Blueprint $table) {
            $table->smallInteger('notification_count')->unsigned()->default(0)->after('notification_slack_channel');
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
            $table->dropColumn('notification_count');
        });
    }
}
