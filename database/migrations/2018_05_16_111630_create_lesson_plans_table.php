<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('priority')->default(100);
            $table->tinyInteger('active')->default(0);
            $table->string('guid1')->default("");
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('country')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('grade_id')->unsigned();
            $table->foreign('grade_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');
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
        Schema::dropIfExists('lesson_plans');
    }
}
