<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeToCourseHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_histories', function (Blueprint $table) {
            $table->time('time')->default('00:00:00');
            $table->unsignedBigInteger('last_completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_histories', function (Blueprint $table) {
            $table->dropColumn(['time', 'last_completed']);
        });
    }
}
