<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_version_files', function (Blueprint $table) {
            $table->unsignedInteger('document_version_id');
            $table->unsignedInteger('file_id');

            $table->foreign('document_version_id')->references('id')->on('document_versions')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_version_files');
    }
}
