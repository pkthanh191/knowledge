<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCentersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('slug');
            $table->string('meta_title');
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('image')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('centers');
    }
}
