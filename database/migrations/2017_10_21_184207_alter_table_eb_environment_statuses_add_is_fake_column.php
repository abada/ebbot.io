<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEbEnvironmentStatusesAddIsFakeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eb_environment_statuses', function (Blueprint $table) {
            $table->boolean('is_fake')->default(false)->after('status_ended_at');
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
            $table->dropColumn('is_fake');
        });
    }
}
