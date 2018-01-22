<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableLogsAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('reference_id');
            $table->string('reference_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('reference_id');
            $table->dropColumn('reference_type');
        });
    }
}
