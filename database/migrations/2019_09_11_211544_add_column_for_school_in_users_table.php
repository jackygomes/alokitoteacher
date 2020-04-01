<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForSchoolInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('overview')->nullable();
            $table->string('location')->nullable();
            $table->integer('no_of_teacher')->nullable();
            $table->integer('no_of_student')->nullable();
            $table->date('founded')->nullable();
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
            $table->dropColumn('overview');
            $table->dropColumn('location');
            $table->dropColumn('exam_syllabus');
            $table->dropColumn('class_size');
            $table->dropColumn('no_of_student');
            $table->dropColumn('founded');
        });
    }
}
