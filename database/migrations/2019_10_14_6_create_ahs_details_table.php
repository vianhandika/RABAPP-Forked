<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAHSDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahs_details', function (Blueprint $table) {
            $table->increments('id_ahs_details');
            $table->unsignedInteger('id_ahs');
            $table->unsignedInteger('id_material');
            $table->double('coefficient');
            $table->double('sub_total');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_ahs')->references('id_ahs')->on('a_h_s_s');
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
        Schema::dropIfExists('ahs_details');
    }
}
