<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExamIdForignKeyAddAnthorOneFromStudentPlacementTestAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_placement_test_answers', function (Blueprint $table) {
         //  $table->dropForeign(['exam_id']);
          //  $table->foreign('exam_id')->references('id')->on('placement_tests')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_placement_test_answers', function (Blueprint $table) {
            //
        });
    }
}
