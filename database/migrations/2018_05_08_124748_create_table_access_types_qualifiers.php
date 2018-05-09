<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAccessTypesQualifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_types_qualifiers', function (Blueprint $table) {
            $table->unsignedInteger('access_type_id');
            $table->unsignedInteger('qualifier_id');

            $table->foreign('access_type_id')
                ->references('id')
                ->on('access_types')
                ->onDelete('cascade');

            $table->foreign('qualifier_id')
                ->references('id')
                ->on('qualifiers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //todo - drop foreign
        Schema::dropIfExists('access_types_qualifiers');
    }
}
