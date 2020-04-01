<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolkitDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toolkit_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('toolkit_id');
            $table->string('toolkit_doc_title');
            $table->string('toolkit_doc_url');
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
        Schema::dropIfExists('toolkit_documents');
    }
}
