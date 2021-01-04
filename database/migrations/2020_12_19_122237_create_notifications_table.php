<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content');
            $table->integer('order_id')->unsigned();
            $table->integer('delegate_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notifications');
    }
}