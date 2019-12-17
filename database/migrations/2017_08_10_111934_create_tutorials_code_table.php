<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorial_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('tutorial_id')->unsigned();
            $table->foreign('tutorial_id')->references('id')->on('tutorials');
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
        Schema::drop('tutorial_codes');
    }
}
