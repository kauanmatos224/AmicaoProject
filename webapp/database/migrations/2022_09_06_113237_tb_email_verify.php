<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_email_verify', function(Blueprint $table){

            $table->id();
            $table->integer('id_org')->unsigned();
            $table->foreign('id_org')->references('id')->on('tb_org');
            $table->string('tmp_token');
            $table->integer('expiration_at');
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_email_verify');
    }
};
