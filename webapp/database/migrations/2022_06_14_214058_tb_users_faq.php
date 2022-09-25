<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbUsersFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_users_faq', function(Blueprint $table){

            $table->id();
            $table->string('fullname');
            $table->string('email');
            $table->string('message');
            $table->string('solicitation_status');
            $table->integer('last_answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_users_faq');
    }
}
