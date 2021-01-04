<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryMethodsTable extends Migration
{

    public function up()
    {
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->default('public/uploads/delivery_methods/default.png');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('delivery_methods');
    }
}