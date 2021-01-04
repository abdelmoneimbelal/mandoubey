<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConnectUsTable extends Migration
{

    public function up()
    {
        Schema::create('connect_us', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', array('problems', 'suggestions', 'balance', 'others'));
            $table->text('content');
            $table->string('image')->nullable();
            $table->integer('delegate_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('connect_us');
    }
}