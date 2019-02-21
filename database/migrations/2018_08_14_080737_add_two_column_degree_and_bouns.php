<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnDegreeAndBouns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_lesson_plan_progresses', function (Blueprint $table) {
            $table->integer('degree')->default(0);
            $table->integer('bonus')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_lesson_plan_progresses', function (Blueprint $table) {
             $table->dropColumn(['degree', 'bonus']);
        });
    }
}
