<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id_material');
            $table->unsignedInteger('id_store');
            $table->string('kode');
            $table->string('name');
            $table->string('type');
            $table->string('satuan');
            $table->double('price');
            $table->string('spesification');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_store')->references('id_store')->on('stores');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
