<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExamIdForignKeyAddAnthorOneFromPlacementTestQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placement_test_questions', function (Blueprint $table) {
          //  $table->dropForeign(['exam_id']);
         //   $table->foreign('exam_id')->references('id')->on('placement_tests')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placement_test_questions', function (Blueprint $table) {
            //
        });
    }
}
