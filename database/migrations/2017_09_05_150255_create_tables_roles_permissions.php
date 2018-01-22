<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesRolesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label');
        });

        Schema::create('permission_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label');
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->unsignedInteger('permission_group_id');

            $table->foreign('permission_group_id')
                ->references('id')
                ->on('permission_groups')
                ->onDelete('cascade');
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->string('access_type', 255)->nullable();
            $table->string('entity_type')->nullable();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');
        });

        Schema::create('qualifiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->unsignedInteger('permission_group_id');

            $table->foreign('permission_group_id')
                ->references('id')
                ->on('permission_groups')
                ->onDelete('cascade');
        });

        Schema::create('qualifier_role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_permission_id');
            $table->unsignedInteger('qualifier_id');
            $table->string('access_type');

            $table->foreign('role_permission_id')
                ->references('id')
                ->on('role_permission')
                ->onDelete('cascade');

            $table->foreign('qualifier_id')
                ->references('id')
                ->on('qualifiers')
                ->onDelete('cascade');
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_group_id']);
        });

        Schema::table('role_permission', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['permission_id']);
        });

        Schema::table('qualifier_role_permission', function (Blueprint $table) {
            $table->dropForeign(['role_permission_id']);
            $table->dropForeign(['qualifier_id']);
        });

        Schema::dropIfExists('qualifier_role_permission');
        Schema::dropIfExists('qualifiers');
        Schema::dropIfExists('role_permission');

        Schema::table('user_role', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('permission_groups');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
