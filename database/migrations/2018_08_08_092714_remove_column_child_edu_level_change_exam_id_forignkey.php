<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnChildEduLevelChangeExamIdForignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placement_test_questions', function (Blueprint $table) {
            //$table->dropForeign(['child_education_level']);
          //  $table->dropColumn('child_education_level');
            //$table->dropForeign(['exam_id']);
           // $table->foreign('exam_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
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
