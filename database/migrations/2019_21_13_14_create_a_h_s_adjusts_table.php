<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAHSAdjustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_h_s_adjusts', function (Blueprint $table) {
            $table->increments('id_ahs_adjust');
            $table->unsignedInteger('id_project');
            $table->unsignedInteger('id_sub');
            $table->unsignedInteger('id_job');
            $table->string('kode');
            $table->double('adjustment');
            $table->double('total_labor');
            $table->double('total_material');
            $table->double('total');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_sub')->references('id_sub')->on('task_subs');
            $table->foreign('id_job')->references('id_job')->on('jobs');
            $table->foreign('id_project')->references('id_project')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_h_s_adjusts');
    }
}
