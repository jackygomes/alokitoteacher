<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add8NewColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          
           $table->date('date_of_birth')->nullable();
           $table->string('curriculum')->nullable();
           $table->string('class_range')->nullable();
           $table->string('description')->nullable();

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
           
           $table->dropColumn('date_of_birth');
           $table->dropColumn('curriculum');
           $table->dropColumn('class_range');
           $table->dropColumn('description');
        });
    }
}
