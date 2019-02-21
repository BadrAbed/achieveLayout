<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateforignkeyGardeidOnlessonplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->dropForeign(['grade_id']);
            $table->foreign(['grade_id'])->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_plans', function (Blueprint $table) {

        });
    }
}
