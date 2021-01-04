<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingPriceTable extends Migration {

	public function up()
	{
		Schema::create('shipping_price', function(Blueprint $table) {
			$table->increments('id');
			$table->string('lat');
			$table->string('long');
			$table->string('weight');
			$table->string('count');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('shipping_price');
	}
}