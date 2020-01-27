<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_sub_details', function (Blueprint $table) {
            $table->increments('id_sub_details');
            $table->unsignedInteger('id_group_details');
            $table->unsignedInteger('id_sub');
            $table->string('name');
            $table->SoftDeletes();

            $table->foreign('id_sub')->references('id_sub')->on('task_subs');
            $table->foreign('id_group_details')->references('id_group_details')->on('group_details');

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
        Schema::dropIfExists('task_sub_details');
    }
}
