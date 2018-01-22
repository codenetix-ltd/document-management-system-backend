<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('template_id');
            $table->unsignedInteger('table_type_row_id')->nullable();
            $table->unsignedInteger('table_type_column_id')->nullable();
            $table->unsignedInteger('parent_attribute_id')->nullable();
            $table->string('name', 255);
            $table->tinyInteger('type_id');
            $table->tinyInteger('is_locked')->default(0);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('attributes');
    }
}
