<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPlacementTestAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_placement_test_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');//student id
            $table->integer("exam_id")->unsigned();
            $table->foreign('exam_id')->references('id')->on('student_placement_tests')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('placement_test_questions')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('student_answer_id')->unsigned();
            $table->foreign('student_answer_id')->references('id')->on('placement_test_question_answers')->onDelete('RESTRICT')->onUpdate('cascade');
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
        Schema::dropIfExists('student_placement_test_answers');
    }
}
