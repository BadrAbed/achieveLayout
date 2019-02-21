<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumsAnswersQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers_questions', function (Blueprint $table) {
            $table->string("degree")->comment("to hold the current user answer degree and it will not modified except if the user has high degree than the current")->default(0);
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
            $table->dropColumn("degree");
        });
    }
}
