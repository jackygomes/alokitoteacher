<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToolkitVideoTitleColumnToToolkitVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toolkit_videos', function (Blueprint $table) {
             $table->string('toolkit_video_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('toolkit_videos', function (Blueprint $table) {
            $table->dropColumn('toolkit_video_title');
        });
    }
}
