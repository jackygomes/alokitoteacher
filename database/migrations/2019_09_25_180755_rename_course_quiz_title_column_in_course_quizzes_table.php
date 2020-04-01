<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCourseQuizTitleColumnInCourseQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_quizzes', function (Blueprint $table) {
             $table->renameColumn('course_quiz_title','quiz_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_quizzes', function (Blueprint $table) {
           $table->renameColumn('quiz_title','course_quiz_title');
        });
    }
}
