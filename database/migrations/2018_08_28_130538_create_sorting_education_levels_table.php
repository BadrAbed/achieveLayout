<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortingEducationLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorting_education_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('education_level_id')->unsigned();
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('sorting');
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
        Schema::dropIfExists('sorting_education_levels');
    }
}
