<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortinglessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortinglessons', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('sorting');
                $table->tinyInteger('active')->default(1);
                $table->string('guid1')->default("");
                $table->integer('lesson_id')->unsigned();
                $table->foreign('lesson_id')->references('id')->on('lesson_plans')->onDelete('cascade')->onUpdate('cascade');
                $table->integer('content_id')->unsigned();
                $table->foreign('content_id')->references('id')->on('content')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('sortinglessons');
    }
}
