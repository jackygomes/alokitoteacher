<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameToolkitVideoTitleColumnInToolkitVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toolkit_videos', function (Blueprint $table) {
            $table->renameColumn('toolkit_video_title','video_title');
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
             $table->renameColumn('video_title','toolkit_video_title');
        });
    }
}
