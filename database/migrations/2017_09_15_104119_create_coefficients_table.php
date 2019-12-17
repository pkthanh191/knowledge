<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoefficientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coefficients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('apply_from')->nullable();
            $table->timestamp('apply_to')->nullable();
            $table->integer('cost_from')->nullable();
            $table->integer('cost_to')->nullable();
            $table->double('coefficient',15,8);
            $table->text('description',255)->nullable();
            $table->softDeletes();
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
        Schema::drop('coefficients');
    }
}
