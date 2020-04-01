<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameToolkitDocTitleColumnInToolkitDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toolkit_documents', function (Blueprint $table) {
             $table->renameColumn('toolkit_doc_title','doc_title');
              $table->renameColumn('toolkit_doc_url','doc_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('toolkit_documents', function (Blueprint $table) {
            $table->renameColumn('doc_title','toolkit_doc_title');
              $table->renameColumn('doc_url','toolkit_doc_url');
        
        });
    }
}
