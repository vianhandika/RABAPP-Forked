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
        Schema::create('r_a_b_details', function (Blueprint $table) {
            $table->increments('id_rab_details');
            $table->unsignedInteger('id_sub_details');
            $table->integer('id_ahs')->unsigned()->nullable();
            $table->integer('id_ahs_adjust')->unsigned()->nullable();
            $table->double('sub_total');
            $table->double('volume');
            $table->double('coefficient');
            $table->double('hp');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_sub_details')->references('id_sub_details')->on('task_sub_details');
            $table->foreign('id_ahs')->references('id_ahs')->on('a_h_s_s');
            $table->foreign('id_ahs_adjust')->references('id_ahs_adjust')->on('a_h_s_adjusts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_a_b_details');
    }
}
