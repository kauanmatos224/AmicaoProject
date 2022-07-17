<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_org', function(Blueprint $table){

            $table->id();
            $table->string('cnpj');
            $table->integer('cep');
            $table->string('endereco');
            $table->string('phone');
            $table->string('country');
            $table->string('nome_fantasia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_org');
    }
}
