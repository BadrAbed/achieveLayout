<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacementTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placement_test_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("exam_id")->unsigned();
            $table->string("question");
            $table->foreign('exam_id')->references('id')->on('student_placement_tests')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('child_education_level')->unsigned()->comment('You must insert child level degrees like grade beginner not grade third preparatory , i meant this is only for the child level degress not for parents , because each question child level will have specific degree to specify at the last , the actual child degree of the student');
            $table->foreign('child_education_level')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->string("guid1")->nullable();
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
        Schema::dropIfExists('placement_test_questions');
    }
}
