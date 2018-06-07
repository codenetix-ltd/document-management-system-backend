<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_actual')->default(0);
            $table->unsignedInteger('template_id');
            $table->unsignedInteger('document_id');
            $table->string('version_name', 255);
            $table->string('name', 255);
            $table->string('comment', 2048)->default('');
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
        Schema::dropIfExists('document_versions');
    }
}
