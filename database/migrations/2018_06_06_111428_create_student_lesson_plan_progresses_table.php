<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentLessonPlanProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_lesson_plan_progresses', function (Blueprint $table) {
            /**
             *
             * A table to know the progress of the user for a the assigned lesson plan.
             */
            $table->increments('id');
            $table->integer('lesson_plan_id')->unsigned();
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->comment("unqiue user because each user has one lesson plan");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("content_id")->unsigned();
            $table->foreign('content_id')->references('id')->on('content')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(["lesson_plan_id","user_id","content_id"],"Unique_User_Lesson_Plan_WithContent")->comment("to create unique row for the user of the lesson plan of the content, to get unqiue row");
            $table->integer("status")->default(0)->comment("Enum to indicate the stauts of the lesson");
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
        Schema::dropIfExists('student_lesson_plan_progresses');
    }
}
