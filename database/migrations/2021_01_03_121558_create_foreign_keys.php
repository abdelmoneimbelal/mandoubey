<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('delegates', function(Blueprint $table) {
			$table->foreign('governorate_id')->references('id')->on('governorates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('delegates', function(Blueprint $table) {
			$table->foreign('delivery_method_id')->references('id')->on('delivery_methods')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->foreign('governorate_id')->references('id')->on('governorates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('delivery_method_id')->references('id')->on('delivery_methods')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('section_id')->references('id')->on('sections')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('delegate_id')->references('id')->on('delegates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('delegate_id')->references('id')->on('delegates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('connect_us', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('connect_us', function(Blueprint $table) {
			$table->foreign('delegate_id')->references('id')->on('delegates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tokens', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tokens', function(Blueprint $table) {
			$table->foreign('delegate_id')->references('id')->on('delegates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('delegates', function(Blueprint $table) {
			$table->dropForeign('delegates_governorate_id_foreign');
		});
		Schema::table('delegates', function(Blueprint $table) {
			$table->dropForeign('delegates_delivery_method_id_foreign');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->dropForeign('cities_governorate_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_delivery_method_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_section_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_client_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_delegate_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_order_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_delegate_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_client_id_foreign');
		});
		Schema::table('connect_us', function(Blueprint $table) {
			$table->dropForeign('connect_us_client_id_foreign');
		});
		Schema::table('connect_us', function(Blueprint $table) {
			$table->dropForeign('connect_us_delegate_id_foreign');
		});
		Schema::table('tokens', function(Blueprint $table) {
			$table->dropForeign('tokens_client_id_foreign');
		});
		Schema::table('tokens', function(Blueprint $table) {
			$table->dropForeign('tokens_delegate_id_foreign');
		});
	}
}