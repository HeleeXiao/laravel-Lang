<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        if ( ! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('name_zh');
                $table->string('name_jp');
                $table->string('description')->nullable();
                $table->integer('status')->comment("状态：0正常，1废弃")->nullable()->default(0);
                $table->timestamps();
            });
        }
        // Create table for associating roles to users (Many-to-Many)
        if ( ! Schema::hasTable('role_user')) {
            Schema::create('role_user', function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['user_id', 'role_id']);
            });
        }

        // Create table for storing permissions
        if ( ! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pid')->index()->comment("父级：0无")->nullable()->default(0);
                $table->string('name')->unique();
                $table->string('name_zh');
                $table->string('name_jp');
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->integer('status')->comment("状态：0正常，1废弃")->nullable()->default(0);
                $table->integer('type')->comment("状态：0菜单，1功能")->nullable()->default(0);
                $table->timestamps();
            });
        }

        // Create table for associating permissions to roles (Many-to-Many)
        if ( ! Schema::hasTable('permission_role')) {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')->references('id')->on('permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
