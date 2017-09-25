<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbEnvironmentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eb_environment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('eb_environment_id')->unsigned();
            $table->string('status', 20);
            $table->timestamp('status_set_at');
            $table->timestamps();
            
            $table->index('eb_environment_id');
            $table->index('status');
            $table->index('status_set_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eb_environment_statuses');
    }
}
