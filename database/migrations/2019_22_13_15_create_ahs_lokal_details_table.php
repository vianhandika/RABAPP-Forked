<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAHSLokalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahs_lokal_details', function (Blueprint $table) {
            $table->increments('id_ahs_lokal_details');
            $table->unsignedInteger('id_ahs_lokal');
            $table->unsignedInteger('id_material');
            $table->string('kode');
            $table->double('coefficient',3);
            $table->double('sub_total',3);
            $table->double('adjustment',3);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_ahs_lokal')->references('id_ahs_lokal')->on('ahs_lokals');
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
        Schema::dropIfExists('ahs_lokal_details');
    }
}
