<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('word')->unique();
            $table->string('type');
            $table->string('meaning');
            $table->text('examples');
            $table->text('relative_words');
            $table->string('meaning_in_english')->nullable();
            $table->integer('education_level_id')->unsigned();
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
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
        Schema::dropIfExists('dictionaries');
    }
}
