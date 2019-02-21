<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllRelationsToContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->foreign('countries')->references('id')->on('country')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('cascade');
            $table->foreign('goal_id')->references('id')->on('learing_goals')->onDelete('RESTRICT')->onUpdate('cascade');
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
            $table->dropForeign(['education_level_id']);

            $table->dropForeign('content_user_id_foreign');
            $table->dropForeign('content_goal_id_foreign');
            $table->dropForeign(['category_id']);
           $table->dropForeign('content_countries_foreign');
        });
    }
}
