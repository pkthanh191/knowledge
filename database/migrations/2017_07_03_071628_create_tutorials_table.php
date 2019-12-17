<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTutorialsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('requirement')->nullable();
            $table->string('period')->nullable();
            $table->integer('frequency')->unsigned()->nullable();
            $table->string('salary')->nullable();
            $table->integer('active')->unsigned()->default(0);
            $table->integer('confirm')->unsigned()->default(0);
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('address')->nullable();
            $table->integer('district_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tutorials');
    }
}
