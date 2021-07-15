<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('institution')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('subject')->nullable();
            $table->string('education_level')->nullable();
            $table->string('is_teacher')->nullable();
            $table->string('years_teaching')->nullable();
            $table->string('teaching_institution')->nullable();
            $table->string('school_type')->nullable();
            $table->text('classes')->nullable();
            $table->text('subjects')->nullable();
            $table->string('previous_training')->nullable();
            $table->string('training_programs')->nullable();
            $table->string('online_workshop')->nullable();
            $table->string('ambassador')->nullable();
            $table->string('ambassador_ref')->nullable();
            $table->string('lead')->nullable();
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
        Schema::dropIfExists('workshop_registrations');
    }
}
