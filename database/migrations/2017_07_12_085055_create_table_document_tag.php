<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDocumentTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_tag', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('tag_id');
        });

        Schema::table('document_tag', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_tag', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['tag_id']);
        });
        Schema::dropIfExists('document_tag');
    }
}
