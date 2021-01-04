<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDelegatesTable extends Migration
{

    public function up()
    {
        Schema::create('delegates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('whatsapp', 20)->unique();
            $table->string('phone', 20)->unique();
            $table->string('password');
            $table->enum('type', array('male', 'female'));
            $table->integer('governorate_id')->unsigned();
            $table->enum('shipping_method', array('now', 'soon'));
            $table->enum('status', array('active', 'inactive'))->default('inactive');
            $table->string('photo')->nullable()->default('public/uploads/delegates/default.png');
            $table->string('id_front');
            $table->string('id_back');
            $table->enum('payment_method', array('before', 'after'));
            $table->integer('delivery_method_id')->unsigned();
            $table->string('pin_code')->nullable();
            $table->enum('ratings', array('1', '2', '3', '4', '5'))->default('1');
            $table->string('email');
            $table->string('terms');
            $table->string('api_token')->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('delegates');
    }
}