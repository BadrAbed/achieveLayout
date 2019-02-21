<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentLessonPlanContentTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_lesson_plan_content_tabs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer("content_id")->unsigned();
            $table->foreign('content_id')->references('id')->on('content')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('lesson_plan_id')->unsigned();
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(["lesson_plan_id","user_id","content_id","tab_enum"],"Unique_User_Lesson_Plan_WithContent_Tab_enum")->comment("user on lesson plan on content id on tab enum is unique");
            $table->integer("tab_enum")->default(0)->comment("each tab has enum , so this is the tab enum");
            $table->integer("status")->default(0)->comment("Enum to indicate the stauts of each tab");
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
        Schema::dropIfExists('student_lesson_plan_content_tabs');
    }
}
