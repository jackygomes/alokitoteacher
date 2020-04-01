<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolkitQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toolkit_quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('toolkit_id');
            $table->string('toolkit_quiz_title');
            $table->integer('pass_grade');
            $table->string('description');
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
        Schema::dropIfExists('toolkit_quizzes');
    }
}
