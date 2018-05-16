<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDocumentLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_version_label', function (Blueprint $table) {
            $table->unsignedInteger('document_version_id');
            $table->unsignedInteger('label_id');
        });

        Schema::table('document_version_label', function (Blueprint $table) {
            $table->foreign('document_version_id')->references('id')->on('document_versions')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_version_label', function (Blueprint $table) {
            $table->dropForeign(['document_version_id']);
            $table->dropForeign(['label_id']);
        });
        Schema::dropIfExists('document_version_label');
    }
}
