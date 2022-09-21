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
        Schema::create('tb_account_op_justify', function(Blueprint $table){

            $table->id();
            $table->integer('id_org')->unsigned();
            $table->foreign('id_org')->references('id')->on('tb_org');
            $table->integer('id_message')->unsigned()->nullable();
            $table->foreign('id_message')->references('id')->on('tb_users_faq')->nullable();
            $table->string('justify');
            $table->string('operation_type');

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_account_op_justify');
    }
};
