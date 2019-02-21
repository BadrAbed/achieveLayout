<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoiceReadAlongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_read_along', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('content')->onDelete('cascade');
            $table->integer('sound_id')->unsigned();
            $table->foreign('sound_id')->references('id')->on('sounds')->onDelete('cascade');
            $table->decimal('startSeconds',20,10)->comment('sentence start in seconds');
            $table->decimal('endSeconds',20,10)->default(0)->comment('sentence end in seconds which will be estimated via the start of the next sentence');
            $table->decimal('duration',20,10)->default(0)->comment('the duration of the sentence which is the difference between the start and the end');
            $table->string('sentence', 300)->default("")->comment('the sentence itself');
            $table->string('guid1', 100)->default("")->comment('general identifier for futher required inputs');
            $table->boolean('status')->default(0)->comment('a field indicates that this coloum has been prepared or not , preparing coloum is to estimate start , end , duration of the sentence and inert it.');//
            $table->timestamps();
            $table->unique(['sound_id', 'startSeconds'])->comment('unique identifier because each second has one sentence and this will help us in deleting any point of time in the video or update it as we do not need to select specific id and delete its row');//set unique constraint on two coloums because there is only one start for each audio file clip , this will help to delete specific point on time without unqiue values from ID.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voice_read_along');
    }
}
