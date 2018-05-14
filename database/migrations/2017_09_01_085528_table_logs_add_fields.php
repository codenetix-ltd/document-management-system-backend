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
            $table->unsignedInteger('user_id');
            $table->integer('reference_id');
            $table->string('reference_type');

            $table->index('user_id', 'logs_user_id_index');
            $table->index(['reference_id', 'reference_type'], 'logs_reference_index');
            $table->foreign('user_id', 'logs_user_id_foreign')
                ->references('id')->on('users')
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
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('reference_id');
            $table->dropColumn('reference_type');
        });
    }
}
