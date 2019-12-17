<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->integer('cost')->unsigned()->nullable();
            $table->string('slug');
            $table->string('meta_title');
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('center_id')->unsigned();
            $table->string('image')->nullable();
            $table->integer('teacher_id')->unsigned();
            $table->integer('comment_counts')->unsigned()->default(0);
            $table->integer('view_counts')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('center_id')->references('id')->on('centers');
            $table->foreign('teacher_id')->references('id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
