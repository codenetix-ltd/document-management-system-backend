<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTablesTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_ticket', function (Blueprint $table) {
            $table->dropForeign(['log_id']);
            $table->dropForeign(['ticket_id']);
        });
        Schema::dropIfExists('log_ticket');
        Schema::dropIfExists('tickets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
