<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbReqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_reqs', function(Blueprint $table){

            $table->id();

            //foreing key
            $table->integer('id_pet')->unsigned();
            $table->foreign('id_pet')->references('id')->on('tb_pets');
            //

            $table->string('nome');
            $table->integer('doc_num');
            $table->string('phone');
            $table->string('email');
            $table->string('endereco');
            $table->string('cep');
            $table->string('country');
            $table->string('obs');
            $table->string('status');
            $table->string('req_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_reqs');
    }
}
