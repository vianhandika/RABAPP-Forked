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
            $table->unsignedInteger('id_rab');
            $table->unsignedInteger('id_ahs');
            $table->double('volume');
            $table->double('sub_total');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_rab')->references('id_rab')->on('rabs');
            $table->foreign('id_ahs')->references('id_ahs')->on('a_h_s_s');
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
