<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkSoundIDToNormalArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('normal_articals', function (Blueprint $table) {
            $table->foreign('sound_id')->references('id')->on('sounds')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('normal_articals', function (Blueprint $table) {
            $table->dropForeign(['sound_id']);
        });
    }
}
