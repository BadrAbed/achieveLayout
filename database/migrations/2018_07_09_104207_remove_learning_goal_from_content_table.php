<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLearningGoalFromContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->dropForeign(["goal_id"]);
            $table->dropColumn("goal_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->integer("goal_id")->unsigned();
            $table->foreign('goal_id')->references('id')->on('learing_goals')->onDelete('RESTRICT')->onUpdate('cascade');
        });
    }
}
