<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlacementTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placement_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exam_name')->unique();
            $table->integer('parent_education_level')->unsigned()->comment('You must insert only first level degrees like grade 1 not beginner , i meant this is only for the first level degress not for children , because the exam itself will examin the entire degree of the first level of the student');
            $table->foreign('parent_education_level')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->unique(["exam_name","parent_education_level"]);
            $table->string('guid_1')->nullable();
            $table->integer('country')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->tinyInteger("status")->default("0")->comment("default as not completed"); //default as not completed
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
        Schema::dropIfExists('placement_tests');
    }
}
