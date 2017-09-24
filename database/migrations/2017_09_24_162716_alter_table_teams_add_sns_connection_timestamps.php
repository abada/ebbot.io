<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTeamsAddSnsConnectionTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->timestamp('sns_subscribed_at')->nullable()->default(null)->after('endpoint');
            $table->timestamp('sns_eb_received_at')->nullable()->default(null)->after('sns_subscribed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('sns_subscribed_at');
            $table->dropColumn('sns_eb_received_at');
        });
    }
}
