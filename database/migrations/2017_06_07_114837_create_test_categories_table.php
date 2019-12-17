<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_test_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_test_id')->references('id')->on('category_tests');
            $table->foreign('test_id')->references('id')->on('tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('test_categories');
    }
}
