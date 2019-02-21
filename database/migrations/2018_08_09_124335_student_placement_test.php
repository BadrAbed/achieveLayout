<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentPlacementTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_placement_test', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->unique(['user_id','level_id']);
            $table->integer('grade');
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
        Schema::table('student_placement_tests', function (Blueprint $table) {
            Schema::dropIfExists('student_placement_test');
        });
    }
}
