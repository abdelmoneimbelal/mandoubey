<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lat');
            $table->string('lat2');
            $table->string('long');
            $table->string('long2');
            $table->string('address');
            $table->string('address2');
            $table->integer('delivery_method_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->string('name');
            $table->string('title');
            $table->enum('payment_method', array('before', 'after', 'without'));
            $table->enum('type', array('male', 'female', 'without'));
            $table->string('weight');
            $table->string('count');
            $table->string('price');
            $table->text('notes')->nullable();
            $table->string('shipping_price');
            $table->string('image');
            $table->string('phone');
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('delegate_id')->unsigned()->nullable();
            $table->string('pin_code')->nullable();
            $table->string('delivery_number')->nullable();
            $table->enum('status', array('former', 'current'))->default('current');
            $table->enum('acceptable', array('accepted', 'pending'))->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('orders');
    }
}