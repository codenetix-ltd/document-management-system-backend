<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTypeAttrTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_type_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_attribute_id');
            $table->string('name', 255);
        });

        Schema::create('table_type_columns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('parent_attribute_id');
            $table->string('name', 255);
        });

        Schema::table('table_type_rows', function (Blueprint $table) {
            $table->foreign('parent_attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('table_type_columns', function (Blueprint $table) {
            $table->foreign('parent_attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_type_columns', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['parent_attribute_id']);
        });


        Schema::table('table_type_rows', function (Blueprint $table) {
            $table->dropForeign(['parent_attribute_id']);
        });

        Schema::dropIfExists('table_type_rows');
        Schema::dropIfExists('table_type_columns');
    }
}
