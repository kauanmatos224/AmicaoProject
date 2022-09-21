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
            $table->string('password');
            $table->integer('logged_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_type');
            $table->string('status');
            $table->string('email_status')->nullable();
            $table->integer('next_mail_sending')->default('0');
            $table->integer('deletion_date')->nullable();
            $table->string('previously_status')->nullable();
            

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
