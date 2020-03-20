<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRABDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahs_lokals', function (Blueprint $table) {
            $table->increments('id_ahs_lokal');
            $table->unsignedInteger('id_sub_details');
            $table->unsignedInteger('id_job');
            $table->double('total_labor');
            $table->double('total_material');
            $table->double('total_equipment');
            $table->double('HSP_before_overhead');
            $table->double('overhead');
            $table->double('HSP');
            $table->double('volume');
            $table->double('adjustment',3);
            $table->double('HP');
            $table->double('HP_Adjust');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_sub_details')->references('id_sub_details')->on('task_sub_details');
            $table->foreign('id_job')->references('id_job')->on('jobs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ahs_lokals');
    }
}
