<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_details', function (Blueprint $table) {
            $table->increments('id_group_details');
            $table->unsignedInteger('id_structure_details');
            $table->unsignedInteger('id_groups');
            $table->SoftDeletes();

            $table->foreign('id_groups')->references('id_groups')->on('groups');
            $table->foreign('id_structure_details')->references('id_structure_details')->on('structure_details');

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
        Schema::dropIfExists('group_details');
    }
}
