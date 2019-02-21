<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInstructionColumnToPlacementTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placement_tests', function (Blueprint $table) {
            $table->longText('instructions')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placement_tests', function (Blueprint $table) {
            $table->dropColumn(['instructions']);
        });
    }
}
