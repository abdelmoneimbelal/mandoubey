<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration
{

    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('delegate_id')->unsigned()->nullable();
            $table->enum('type', array('android', 'ios'));
            $table->string('token');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('tokens');
    }
}