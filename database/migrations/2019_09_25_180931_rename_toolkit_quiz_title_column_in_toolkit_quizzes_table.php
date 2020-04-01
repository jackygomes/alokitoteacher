<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameToolkitQuizTitleColumnInToolkitQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toolkit_quizzes', function (Blueprint $table) {
            $table->renameColumn('toolkit_quiz_title','quiz_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('toolkit_quizzes', function (Blueprint $table) {
            $table->renameColumn('quiz_title','toolkit_quiz_title');
        });
    }
}
