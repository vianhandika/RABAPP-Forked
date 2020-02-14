<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructureDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_details', function (Blueprint $table) {
            $table->increments('id_structure_details');
            $table->unsignedInteger('id_rab');
            $table->unsignedInteger('id_structure');
            $table->SoftDeletes();

            $table->foreign('id_structure')->references('id_structure')->on('structures');
            $table->foreign('id_rab')->references('id_rab')->on('rabs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_details');
    }
}
