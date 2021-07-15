<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 9, 3)->default(0.0);
            $table->text('preview_video')->nullable();
            $table->text('trainers')->nullable();
            $table->text('thumbnail')->nullable();
            $table->string('type')->nullable();
            $table->string('duration')->nullable();
            $table->string('total_credit_hours')->nullable();
            $table->string('date_time')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('last_date')->nullable();
            $table->text('about_this_workshop')->nullable();
            $table->text('what_you_will_learn')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('workshops');
    }
}
