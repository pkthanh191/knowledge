<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_id')->unsigned();
            $table->string('avatar')->nullable();
            $table->integer('age')->nullable();
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->integer('sex')->nullable();
            $table->integer('account_balance');
            $table->integer('actived')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
