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
        Schema::create('document_label', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('label_id');
        });

        Schema::table('document_label', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('no action');
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
        Schema::table('document_label', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['label_id']);
        });
        Schema::dropIfExists('document_label');
    }
}
