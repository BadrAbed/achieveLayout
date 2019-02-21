<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnReattemptToAnswerQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers_questions', function (Blueprint $table) {
           /* $table->integer('reattempt_questions');
            $table->integer('status');
            $table->integer('lesson_plan_id')->unsigned()->defulat(1);
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers_questions', function (Blueprint $table) {
		$table->dropForeign(['lesson_plan_id']);
                  $table->dropColumn(['reattempt_questions', 'status', 'lesson_plan_id']);
				  

        });
    }
}
