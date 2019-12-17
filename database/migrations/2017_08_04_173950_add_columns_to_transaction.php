<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('trans_id')->nullable();
            $table->integer('trans_type')->nullable();
            $table->integer('trans_status')->nullable();
            $table->string('trans_email')->nullable();
            $table->string('trans_phone')->nullable();
            $table->string('trans_payment_name')->nullable();
            $table->string('trans_fee')->nullable();
            $table->string('trans_card_type')->nullable();
            $table->string('trans_card_amount')->nullable();
            $table->integer('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
