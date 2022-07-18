<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbPets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pets', function(Blueprint $table){
            $table->id();
            
            $table->integer('id_org')->unsigned();
            $table->foreign('id_org')->references('id')->on('tb_org');
            
            $table->string('nome');
            $table->string('raca_pai')->nullable();
            $table->string('raca_mae')->nullable();
            $table->string('raca');
            $table->timestamp('nascimento')->nullable();
            $table->string('idade');
            $table->string('status')->nullable();
            $table->string('comportamento')->nullable();
            $table->string('genero');
            $table->string('img_path')->nullable();
            $table->string('porte');
            $table->string('vacinas_essenciais');
            $table->string('saude')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pets');
    }
}
