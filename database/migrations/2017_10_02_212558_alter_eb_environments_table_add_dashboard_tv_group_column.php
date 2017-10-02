<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEbEnvironmentsTableAddDashboardTvGroupColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environments', function (Blueprint $table) {
            $table->string('dashboard_tv_group')->nullable()->default(null)->after('dashboard_tv');
            $table->index('dashboard_tv_group');
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
            $table->dropColumn('dashboard_tv_group');
        });
    }
}
