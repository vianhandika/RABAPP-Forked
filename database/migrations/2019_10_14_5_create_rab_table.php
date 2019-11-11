<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRABTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rabs', function (Blueprint $table) {
            $table->increments('id_rab');
            $table->unsignedInteger('id_project');
            $table->unsignedInteger('id_ahs');
            $table->string('kode');
            $table->double('coefficient');
            $table->double('total_rab');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_project')->references('id_project')->on('projects');
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
        Schema::dropIfExists('rabs');
    }
}
