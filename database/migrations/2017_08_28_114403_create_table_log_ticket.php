<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_ticket', function (Blueprint $table) {
            $table->unsignedInteger('log_id');
            $table->unsignedInteger('ticket_id');
        });

        Schema::table('log_ticket', function (Blueprint $table) {
            $table->foreign('log_id')->references('id')->on('logs')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_ticket');
    }
}
