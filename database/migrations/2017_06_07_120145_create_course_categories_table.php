<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_course_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_course_id')->references('id')->on('category_courses');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_categories');
    }
}
