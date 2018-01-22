<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->unique();
            $table->timestamps();
        });

        Schema::create('document_factories', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('factory_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factories');
        Schema::dropIfExists('document_factories');
    }
}
