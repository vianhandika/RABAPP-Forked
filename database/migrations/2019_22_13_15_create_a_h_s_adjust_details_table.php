<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAHSAdjustDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_h_s_adjust_details', function (Blueprint $table) {
            $table->increments('id_ahs_details_adjust');
            $table->unsignedInteger('id_ahs_adjust');
            $table->unsignedInteger('id_material');
            $table->double('price_ahs');
            $table->double('sub_adjustment');
            $table->double('sub_total');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_ahs_adjust')->references('id_ahs_adjust')->on('a_h_s_adjusts');
            $table->foreign('id_material')->references('id_material')->on('materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_h_s_adjust_details');
    }
}
