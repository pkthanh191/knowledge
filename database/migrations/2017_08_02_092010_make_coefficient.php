<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCoefficient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the table
        Schema::create('coefficient', function($table){
            $table->bigInteger('from_cost');
            $table->bigInteger('to_cost');
            $table->double('coefficient', 15, 8);
            $table->string('description', 255);
        });

        // Insert some stuff
        DB::table('coefficient')->insert(
            array(
                'from_cost' => 0,
                'to_cost' => 100000,
                'coefficient' => 90.0,
                'description' => 'Hệ số chuyển từ 1 KNOW sang VND',
            )
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coefficient');
    }
}
