<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('education_level_id')->unsigned();
            $table->integer('countries')->unsigned()->nullable();
            $table->string('content_name');
            $table->string('abstract');
            $table->text('poll');
            $table->string('cover_image');
            $table->integer('complete')->default('0')->unsigned();
            $table->integer('publish')->default('1')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('goal_id')->unsigned();
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
        Schema::dropIfExists('content');
    }
}
