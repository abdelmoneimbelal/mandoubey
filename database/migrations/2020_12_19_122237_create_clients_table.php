<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration
{

    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('terms');
            $table->string('password')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('photo')->nullable()->default('uploads/delegates/default.png');
            $table->string('id_front');
            $table->string('id_back');
            $table->enum('status', array('active', 'inactive'))->default('inactive');
            $table->enum('type', array('male', 'female', 'company'));
            $table->enum('ratings', array('1', '2', '3', '4', '5'));
            $table->string('api_token')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('clients');
    }
}