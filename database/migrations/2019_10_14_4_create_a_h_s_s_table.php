<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAHSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_h_s_s', function (Blueprint $table) {
            $table->increments('id_ahs');
            $table->unsignedInteger('id_job');
            $table->string('kode');
            $table->double('total');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('a_h_s_s');
    }
}
