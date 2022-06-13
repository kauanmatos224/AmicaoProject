<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbAuthOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_auth_org', function(Blueprint $table){

            $table->id();

            $table->integer('id_org')->unsigned();
            $table->foreign('id_org')->references('id')->on('tb_org');
            
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('phone');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_auth_org');
    }
}
