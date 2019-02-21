<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentExtraColumsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer("student_country_id")->nullable()->comment("nullable because if the row was to admin not student");//nullable because if the row was to admin not student
            $table->integer("student_grade_id")->nullable()->comment("nullable because if the row was to admin not student");//nullable because if the row was to admin not student
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["student_country_id","student_grade_id"]);
        });
    }
}
