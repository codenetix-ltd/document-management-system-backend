<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('no action')->onUpdate('no action');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('document_versions', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('table_type_row_id')->references('id')->on('table_type_rows')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('table_type_column_id')->references('id')->on('table_type_columns')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('no action')->onUpdate('no action');
            $table->foreign('document_version_id')->references('id')->on('document_versions')->onDelete('cascade')->onUpdate('no action');
        });

        Schema::table('document_factories', function (Blueprint $table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('factory_id')->references('id')->on('factories')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_factories', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['factory_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropForeign(['owner_id']);
        });

        Schema::table('document_versions', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropForeign(['table_type_row_id']);
            $table->dropForeign(['table_type_column_id']);
        });

        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign(['document_version_id']);
            $table->dropForeign(['attribute_id']);
        });
    }
}
