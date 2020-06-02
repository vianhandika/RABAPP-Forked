<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id_job');
            $table->unsignedInteger('id_satuan');
            $table->string('kode');
            $table->string('name')->unique();
            $table->string('status');
            $table->string('details');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_satuan')->references('id_satuan')->on('satuans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
