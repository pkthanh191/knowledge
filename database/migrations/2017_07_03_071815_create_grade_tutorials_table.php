<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGradeTutorialsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_tutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grade_id')->unsigned();
            $table->integer('tutorial_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('tutorial_id')->references('id')->on('tutorials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grade_tutorials');
    }
}
