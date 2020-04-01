<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToBookWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_workshops', function (Blueprint $table) {
            $table->integer('total_person');
            $table->string('book_workshop');
            $table->string('time_slot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_workshops', function (Blueprint $table) {
            $table->dropColumn(['total_person', 'book_workshop', 'time_slot']);
        });
    }
}
