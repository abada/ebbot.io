<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEbEnvironmentsTableAddDashboardTvColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environments', function (Blueprint $table) {
            $table->boolean('dashboard_tv', 'after_updated_at')->default(true);
            $table->index('dashboard_tv');
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
            $table->dropColumn('dashboard_tv');
        });
    }
}
