<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAssignedLessonPlansTable extends Migration
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
         *
         *  each student will have signle lesson plan in the grade and then will be upgraded to the next grade
         *
         */
        Schema::create('student_assigned_lesson_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_plan_id')->unsigned();
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->unique()->comment("unqiue user because each user has one lesson plan");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("currentTabEnum")->default(0)->comment("a column which will indicate the current tab content related to the button of 'mark tab as finished' , and will has the values forexample 0=> first tab , 1=> second tab and so on");
            $table->integer("currentLessonID")->comment("will hold the first content at the lesson plan and it indicate the current lesson which the user must be redirected to")->unsigned();
            $table->foreign('currentLessonID')->references('id')->on('content')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("education_level")->unsigned();
            $table->foreign('education_level')->references('id')->on('education_levels')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('student_assigned_lesson_plans');
    }
}
