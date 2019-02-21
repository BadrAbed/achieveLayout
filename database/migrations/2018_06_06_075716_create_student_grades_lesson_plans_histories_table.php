<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentGradesLessonPlansHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *
         * A table to save the history of the student after each finished grade.
         * this table will be used to save the finished degree because at the current time , each student will have signle lesson plan in the grade and then will be upgraded to the next grade
         *
         */
        Schema::create('student_grades_lesson_plans_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("lesson_plan_id")->unsigned();
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("education_level")->unsigned();
            $table->foreign('education_level')->references('id')->on('education_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("status")->default(0)->comment("Enum to indicate if the lesson plan has been finished or not");
            $table->string("guid1")->default("");
            $table->string("guid2")->default("");
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
        Schema::dropIfExists('student_grades_lesson_plans_histories');
    }
}
