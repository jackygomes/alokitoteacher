<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCourseDocTitleColumnInCourseDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_documents', function (Blueprint $table) {
             $table->renameColumn('course_doc_title','doc_title');
              $table->renameColumn('course_doc_url','doc_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_documents', function (Blueprint $table) {
             $table->renameColumn('doc_title','course_doc_title');
              $table->renameColumn('doc_url','course_doc_url');
        });
    }
}
