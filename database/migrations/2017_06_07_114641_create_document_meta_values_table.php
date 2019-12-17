<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentMetaValuesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_meta_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doc_id')->unsigned();
            $table->integer('doc_meta_id')->unsigned();
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('doc_id')->references('id')->on('documents');
            $table->foreign('doc_meta_id')->references('id')->on('document_metas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_meta_values');
    }
}
